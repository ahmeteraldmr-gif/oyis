<?php

namespace App\Livewire\Coach;

use App\Models\Course;
use App\Models\ScheduleItem;
use App\Models\StudySchedule;
use App\Models\Topic;
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

    // Inline assignment inputs
    public $selectedCourseId;
    public $questionCountsByTopic = []; // topic_id => count
    public $timeSlot = '09:00-10:00'; // Default time slot if timed schedule is selected

    // Lists
    public $courses = [];
    public $topics = [];

    // Draft list
    public $draftItems = [];

    public $timeSlots = [
        '06:00-07:00', '07:00-08:00', '08:00-09:00', '09:00-10:00',
        '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00',
        '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00',
        '18:00-19:00', '19:00-20:00', '20:00-21:00', '21:00-22:00',
        '22:00-23:00', '23:00-00:00'
    ];

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

        // Auto-select the first course on load
        $firstCourseId = null;
        if (!empty($this->courses['tyt']) && count($this->courses['tyt']) > 0) {
            $firstCourseId = $this->courses['tyt']->first()->id;
        } elseif (!empty($this->courses['ayt']) && count($this->courses['ayt']) > 0) {
            $firstCourseId = $this->courses['ayt']->first()->id;
        } elseif (!empty($this->courses['other']) && count($this->courses['other']) > 0) {
            $firstCourseId = $this->courses['other']->first()->id;
        }

        if ($firstCourseId) {
            $this->selectCourse($firstCourseId);
        }
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

    public function selectCourse($courseId)
    {
        $this->selectedCourseId = $courseId;
        $this->topics = Topic::where('course_id', $courseId)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        foreach ($this->topics as $topic) {
            if (!isset($this->questionCountsByTopic[$topic->id])) {
                $this->questionCountsByTopic[$topic->id] = 50; // Default count
            }
        }
    }

    public function toggleDayForTopic($topicId, $dayNum)
    {
        $course = Course::find($this->selectedCourseId);
        $topic = Topic::find($topicId);

        if (!$course || !$topic) return;

        // Check if this topic is already assigned to this day in the draft
        $existingIndex = null;
        foreach ($this->draftItems as $index => $item) {
            if ($item['topic_id'] == $topicId && $item['day_of_week'] == $dayNum) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            // Toggle off: remove from draft
            unset($this->draftItems[$existingIndex]);
            $this->draftItems = array_values($this->draftItems);
        } else {
            // Toggle on: add to draft
            $count = isset($this->questionCountsByTopic[$topicId]) ? (int) $this->questionCountsByTopic[$topicId] : 50;
            
            $this->draftItems[] = [
                'temp_id' => uniqid('item_'),
                'day_of_week' => (int) $dayNum,
                'course_id' => $course->id,
                'course_name' => $course->name,
                'topic_id' => $topic->id,
                'topic_name' => $topic->name,
                'sub_topic_id' => null,
                'sub_topic_name' => 'Tüm Alt Başlıklar',
                'question_count' => $count,
                'description' => '',
                'time_slot' => $this->scheduleType === 'timed' ? $this->timeSlot : null,
            ];
        }
    }

    public function updated($property, $value)
    {
        // Real-time synchronization when inline question count inputs are modified
        if (str_starts_with($property, 'questionCountsByTopic.')) {
            $topicId = str_replace('questionCountsByTopic.', '', $property);
            $newCount = (int) $value;

            foreach ($this->draftItems as &$item) {
                if ($item['topic_id'] == $topicId) {
                    $item['question_count'] = $newCount;
                }
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
                'visible_time_slots' => $this->scheduleType === 'timed' ? $this->timeSlots : [],
            ]);

            // 2. Create ScheduleItems
            foreach ($this->draftItems as $index => $item) {
                ScheduleItem::create([
                    'schedule_id' => $schedule->id,
                    'day_of_week' => $item['day_of_week'],
                    'time_slot' => $item['time_slot'],
                    'course_id' => $item['course_id'],
                    'topic_id' => $item['topic_id'],
                    'sub_topic_id' => $item['sub_topic_id'],
                    'question_count' => $item['question_count'],
                    'description' => $item['description'],
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
