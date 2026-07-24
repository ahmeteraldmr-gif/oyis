<?php

namespace App\Livewire\Coach;

use App\Models\Course;
use App\Models\ScheduleItem;
use App\Models\StudySchedule;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QuickScheduleBuilder extends Component
{
    public $studentId;
    public $student;

    // Schedule metadata
    public $scheduleName;
    public $startDate;
    public $endDate;
    public $weekNumber = 1;
    public $scheduleType = 'daily'; // 'daily' (saatsiz) or 'timed' (saatli)
    public $isActive = true;

    // Navigation and Toggles
    public $activeDay = 1; // Current weekday selected (1 = Pazartesi, ..., 7 = Pazar)

    // Lists
    public $courses = [];

    // Draft list
    public $draftItems = [];

    public function mount($studentId)
    {
        $this->studentId = $studentId;
        $this->student = User::findOrFail($studentId);

        // Authorization check
        if (!auth()->user()->students()->where('users.id', $studentId)->exists()) {
            abort(403, 'Bu öğrenciye erişim yetkiniz yok.');
        }

        // Set default date range (next week Monday to Sunday)
        $nextMonday = now()->next(\Carbon\Carbon::MONDAY);
        $this->startDate = $nextMonday->format('Y-m-d');
        $this->endDate = $nextMonday->copy()->addDays(6)->format('Y-m-d');

        // Set default week number
        $existingCount = StudySchedule::where('coach_id', auth()->id())
            ->where('student_id', $this->studentId)
            ->where('is_template', false)
            ->count();
        $this->weekNumber = $existingCount + 1;

        // Set default schedule name
        $this->scheduleName = "{$this->student->name} - {$this->weekNumber}. Hafta Programı";

        $this->loadCourses();
    }

    public function loadCourses()
    {
        $allCourses = Course::where('is_active', true)
            ->with('field')
            ->orderBy('name')
            ->get();

        $tytCourses = $allCourses->filter(function ($course) {
            return $course->field && strtolower($course->field->slug) === 'tyt';
        })->sortBy('name');

        $aytCourses = $allCourses->filter(function ($course) {
            return $course->field && strtolower($course->field->slug) === 'ayt';
        })->sortBy('name');

        $otherCourses = $allCourses->filter(function ($course) {
            return !$course->field ||
                (strtolower($course->field->slug) !== 'tyt' &&
                    strtolower($course->field->slug) !== 'ayt');
        })->sortBy('name');

        $this->courses = [
            'tyt' => $tytCourses,
            'ayt' => $aytCourses,
            'other' => $otherCourses,
        ];
    }

    public function setActiveDay($day)
    {
        $this->activeDay = (int) $day;
    }

    public function toggleCourseForActiveDay($courseId)
    {
        // Check if this course is already assigned to the active day in the draft
        $existingIndex = null;
        foreach ($this->draftItems as $index => $item) {
            if ($item['course_id'] == $courseId && $item['day_of_week'] == $this->activeDay) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            // Remove from draft
            unset($this->draftItems[$existingIndex]);
            $this->draftItems = array_values($this->draftItems);
        } else {
            // Add to draft
            $course = Course::find($courseId);
            if ($course) {
                $this->draftItems[] = [
                    'temp_id' => uniqid('item_'),
                    'day_of_week' => $this->activeDay,
                    'course_id' => $course->id,
                    'course_name' => $course->name,
                    'topic_id' => null,
                    'sub_topic_id' => null,
                    'question_count' => 0,
                    'description' => null,
                    'time_slot' => null,
                ];
            }
        }
    }

    public function removeFromDraft($tempId)
    {
        $this->draftItems = array_filter($this->draftItems, function ($item) use ($tempId) {
            return $item['temp_id'] !== $tempId;
        });

        // Reindex array
        $this->draftItems = array_values($this->draftItems);
    }

    public function saveSchedule()
    {
        $this->validate([
            'scheduleName' => 'required|string|max:255',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'weekNumber' => 'required|integer|min:1',
            'draftItems' => 'required|array|min:1',
        ], [
            'scheduleName.required' => 'Program adı boş bırakılamaz.',
            'draftItems.required' => 'Lütfen en az bir gün için ders planlaması yapın.',
            'draftItems.min' => 'Lütfen en az bir gün için ders planlaması yapın.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create the StudySchedule
            $schedule = StudySchedule::create([
                'coach_id' => auth()->id(),
                'student_id' => $this->studentId,
                'name' => $this->scheduleName,
                'is_active' => $this->isActive,
                'is_template' => false,
                'is_master_template' => false,
                'schedule_type' => $this->scheduleType,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'week_number' => $this->weekNumber,
                'visible_time_slots' => [],
            ]);

            // 2. Create ScheduleItems
            foreach ($this->draftItems as $index => $item) {
                ScheduleItem::create([
                    'schedule_id' => $schedule->id,
                    'day_of_week' => $item['day_of_week'],
                    'time_slot' => null,
                    'course_id' => $item['course_id'],
                    'topic_id' => null,
                    'sub_topic_id' => null,
                    'question_count' => 0,
                    'description' => null,
                    'order' => $index,
                    'is_active' => true,
                ]);
            }

            DB::commit();

            session()->flash('message', 'Hızlı program başarıyla oluşturuldu ve öğrenciye atandı.');
            return redirect()->route('coach.students');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Program kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.coach.quick-schedule-builder');
    }
}
