<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class CoachManagement extends Component
{
    use WithPagination;

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $coachId;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $subscription_plan_id;
    public $duration_days = 30; // Varsayılan 30 Gün
    public $student_limit = 20; // Varsayılan 20 Öğrenci
    public $is_active = true;

    // Search & Filter
    public $search = '';
    public $filterStatus = '';

    protected $queryString = ['search', 'filterStatus'];

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->coachId,
            'phone' => 'nullable|string|max:20',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
            'duration_days' => 'required|integer|min:1|max:3650',
            'student_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|min:6';
        } elseif ($this->password) {
            $rules['password'] = 'min:6';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten sistemde kayıtlı! (Admin, Koç veya Öğrenci hesabı olarak kullanılıyor).',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'duration_days.required' => 'Abonelik süresi (gün) zorunludur.',
            'duration_days.min' => 'Abonelik süresi en az 1 gün olmalıdır.',
            'student_limit.min' => 'Öğrenci kontenjanı en az 1 olmalıdır.',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['coachId', 'name', 'email', 'password', 'phone', 'subscription_plan_id', 'editMode']);
        $this->duration_days = 30;
        $this->student_limit = 20;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $coachRole = Role::where('name', 'coach')->first();
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays((int) $this->duration_days);

        if ($this->editMode) {
            $coach = User::findOrFail($this->coachId);
            $coach->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_active' => $this->is_active,
                'created_by' => auth()->id(),
            ]);

            if ($this->password) {
                $coach->update(['password' => Hash::make($this->password)]);
            }

            // Update or Create Subscription
            Subscription::updateOrCreate(
                ['user_id' => $coach->id],
                [
                    'subscription_plan_id' => $this->subscription_plan_id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'next_payment_date' => $endDate,
                    'is_active' => $this->is_active,
                    'student_limit' => $this->student_limit ? (int) $this->student_limit : null,
                ]
            );

            session()->flash('message', 'Koç ve abonelik bilgileri başarıyla güncellendi.');
        } else {
            $coach = User::create([
                'role_id' => $coachRole->id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'is_active' => $this->is_active,
                'created_by' => auth()->id(),
            ]);

            // Create Subscription with duration and student limit
            Subscription::create([
                'user_id' => $coach->id,
                'subscription_plan_id' => $this->subscription_plan_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'next_payment_date' => $endDate,
                'is_active' => $this->is_active,
                'is_trial' => false,
                'student_limit' => $this->student_limit ? (int) $this->student_limit : null,
            ]);

            session()->flash('message', 'Koç başarıyla eklendi ve aboneliği başlatıldı.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $coach = User::with('subscription')->findOrFail($id);
        
        $this->coachId = $coach->id;
        $this->name = $coach->name;
        $this->email = $coach->email;
        $this->phone = $coach->phone;
        $this->is_active = $coach->is_active;
        $this->subscription_plan_id = $coach->subscription?->subscription_plan_id;
        
        if ($coach->subscription && $coach->subscription->end_date) {
            $remainingDays = Carbon::now()->diffInDays($coach->subscription->end_date, false);
            $this->duration_days = $remainingDays > 0 ? (int) $remainingDays : 30;
            $this->student_limit = $coach->subscription->student_limit ?? 20;
        } else {
            $this->duration_days = 30;
            $this->student_limit = 20;
        }

        $this->editMode = true;
        $this->showModal = true;
    }

    public function toggleStatus($id)
    {
        $coach = User::findOrFail($id);
        $coach->update(['is_active' => !$coach->is_active]);
        
        session()->flash('message', 'Koç durumu güncellendi.');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Koç silindi.');
    }

    public function render()
    {
        $coachRole = Role::where('name', 'coach')->first();
        $user = auth()->user();
        
        $coaches = User::where('role_id', $coachRole->id)
            ->with(['subscription.plan', 'students'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->when(!$user->isSuperAdmin(), function ($query) use ($user) {
                $query->where('created_by', $user->id);
            })
            ->latest()
            ->paginate(10);

        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

        return view('livewire.admin.coach-management', [
            'coaches' => $coaches,
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }
}
