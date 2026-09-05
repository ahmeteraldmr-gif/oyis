<?php

namespace App\Livewire\Admin;

use App\Models\CoachStudent;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class AdminManagement extends Component
{
    use WithPagination;

    // Form properties
    public $showModal = false;
    public $editMode = false;
    public $adminId;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $subscription_plan_id;
    public $is_active = true;

    // Expanded row for coach details
    public $expandedAdminId = null;

    public function toggleExpand($id)
    {
        $id = (int) $id;
        $this->expandedAdminId = $this->expandedAdminId === $id ? null : $id;
    }

    // Search & Filter
    public $search = '';
    public $filterStatus = '';

    protected $queryString = ['search', 'filterStatus'];

    public function mount()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->adminId,
            'phone' => 'nullable|string|max:20',
            'subscription_plan_id' => 'nullable|exists:subscription_plans,id',
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
        $this->reset(['adminId', 'name', 'email', 'password', 'phone', 'subscription_plan_id', 'editMode']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $adminRole = Role::where('name', 'admin')->first();

        if ($this->editMode) {
            $admin = User::findOrFail($this->adminId);
            $admin->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_active' => $this->is_active,
            ]);

            if ($this->password) {
                $admin->update(['password' => Hash::make($this->password)]);
            }

            // Update or create subscription if specified
            if ($this->subscription_plan_id) {
                $subscription = $admin->subscription;
                if ($subscription) {
                    $subscription->update([
                        'subscription_plan_id' => $this->subscription_plan_id,
                    ]);
                } else {
                    Subscription::create([
                        'user_id' => $admin->id,
                        'subscription_plan_id' => $this->subscription_plan_id,
                        'start_date' => Carbon::now(),
                        'end_date' => Carbon::now()->addYear(),
                        'next_payment_date' => Carbon::now()->addYear(),
                        'is_active' => true,
                        'is_trial' => false,
                    ]);
                }
            }

            session()->flash('message', 'Kurum (Admin) başarıyla güncellendi.');
        } else {
            $admin = User::create([
                'role_id' => $adminRole->id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'is_active' => $this->is_active,
                'created_by' => auth()->id(),
            ]);

            // Create subscription if specified
            if ($this->subscription_plan_id) {
                Subscription::create([
                    'user_id' => $admin->id,
                    'subscription_plan_id' => $this->subscription_plan_id,
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addYear(),
                    'next_payment_date' => Carbon::now()->addYear(),
                    'is_active' => true,
                    'is_trial' => false,
                ]);
            }

            session()->flash('message', 'Kurum (Admin) başarıyla eklendi.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $admin = User::with('subscription')->findOrFail($id);
        
        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->is_active = $admin->is_active;
        $this->subscription_plan_id = $admin->subscription?->subscription_plan_id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function toggleStatus($id)
    {
        $admin = User::findOrFail($id);
        $admin->update(['is_active' => !$admin->is_active]);
        
        session()->flash('message', 'Kurum durumu güncellendi.');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Kurum silindi.');
    }

    public function render()
    {
        $adminRole = Role::where('name', 'admin')->first();
        
        $coachRole = Role::where('name', 'coach')->first();
        $studentRole = Role::where('name', 'student')->first();

        $admins = User::where('role_id', $adminRole->id)
            ->with(['subscription.plan'])
            ->withCount([
                'createdCoaches as coaches_count',
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        foreach ($admins as $admin) {
            $coachIds = User::where('created_by', $admin->id)->pluck('id');
            $admin->students_count = CoachStudent::whereIn('coach_id', $coachIds)->distinct('student_id')->count('student_id');
        }

        // Load coaches for expanded admin
        $expandedCoaches = null;
        if ($this->expandedAdminId) {
            $expandedCoaches = User::where('role_id', $coachRole->id)
                ->where('created_by', $this->expandedAdminId)
                ->withCount('students')
                ->get();
        }

        $subscriptionPlans = SubscriptionPlan::where('is_active', true)->get();

        return view('livewire.admin.admin-management', [
            'admins' => $admins,
            'subscriptionPlans' => $subscriptionPlans,
            'expandedCoaches' => $expandedCoaches,
        ])->layout('components.layouts.admin');
    }
}
