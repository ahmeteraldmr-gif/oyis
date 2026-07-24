<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kurum (Okul / Merkez) Yönetimi</h2>
            <p class="text-sm text-gray-600 mt-1">Sistemdeki tüm kurumları yönetin ve izleyin</p>
        </div>
        <button wire:click="openModal" class="btn-primary">
            + Yeni Kurum Ekle
        </button>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="card">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Kurum adı veya e-posta ile ara..."
                    class="input-field"
                >
            </div>
            <div>
                <select wire:model.live="filterStatus" class="input-field">
                    <option value="">Tüm Durumlar</option>
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kurum Bilgileri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İletişim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Koç / Öğrenci
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Abonelik Paketi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Durum
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($admins as $admin)
                        <!-- Main Row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-center">
                                <button wire:click="toggleExpand({{ $admin->id }})" class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-blue-50">
                                    @if($expandedAdminId == $admin->id)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    @endif
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-accent-blue flex items-center justify-center text-white font-medium flex-shrink-0">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                        <div class="text-xs text-gray-500">Kayıt: {{ $admin->created_at->format('d.m.Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                                <div class="text-xs text-gray-500">{{ $admin->phone ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $admin->coaches_count }} Koç
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                        </svg>
                                        {{ $admin->students_count }} Öğrenci
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($admin->subscription)
                                    <div class="text-sm font-medium text-blue-600">{{ $admin->subscription->plan->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        Limit: {{ $admin->subscription->plan->student_limit ?: 'Sınırsız' }} Öğrenci
                                    </div>
                                @else
                                    <span class="text-xs text-red-600">Abonelik Yok</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button 
                                    wire:click.stop="toggleStatus({{ $admin->id }})"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors {{ $admin->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                >
                                    {{ $admin->is_active ? 'Aktif' : 'Pasif' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button wire:click.stop="edit({{ $admin->id }})" class="text-blue-600 hover:text-blue-900">
                                        Düzenle
                                    </button>
                                    <button 
                                        wire:click.stop="delete({{ $admin->id }})" 
                                        onclick="confirm('Bu kurumu silmek istediğinizden emin misiniz?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Sil
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Expanded Coaches Row -->
                        @if($expandedAdminId == $admin->id)
                            <tr>
                                <td colspan="7" class="px-6 py-4 bg-blue-50 border-b border-blue-100">
                                    <div class="ml-10">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $admin->name }} — Koç Listesi
                                        </h4>

                                        @if($expandedCoaches && $expandedCoaches->count() > 0)
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                @foreach($expandedCoaches as $coach)
                                                    <div class="bg-white rounded-lg border border-blue-200 p-3 flex items-center gap-3">
                                                        <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium flex-shrink-0">
                                                            {{ substr($coach->name, 0, 1) }}
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $coach->name }}</div>
                                                            <div class="text-xs text-gray-500 truncate">{{ $coach->email }}</div>
                                                            <div class="text-xs text-gray-500">{{ $coach->phone ?: 'Tel yok' }}</div>
                                                        </div>
                                                        <div class="text-right flex-shrink-0">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">
                                                                {{ $coach->students_count }} öğrenci
                                                            </span>
                                                            <div class="mt-1">
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs {{ $coach->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                                    {{ $coach->is_active ? 'Aktif' : 'Pasif' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic">Bu kurumda henüz koç kaydı yok.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                Kayıtlı kurum bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative z-50 inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" onclick="event.stopPropagation()">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                {{ $editMode ? 'Kurum Düzenle' : 'Yeni Kurum Ekle' }}
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="form-label">Kurum / Okul Adı</label>
                                    <input type="text" wire:model="name" class="input-field">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="form-label">E-posta (Giriş Adresi)</label>
                                    <input type="email" wire:model="email" class="input-field">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="form-label">Şifre {{ $editMode ? '(Değiştirmek istemiyorsanız boş bırakın)' : '' }}</label>
                                    <input type="password" wire:model="password" class="input-field">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="form-label">Telefon</label>
                                    <input type="text" wire:model="phone" class="input-field">
                                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="form-label">Abonelik Paketi</label>
                                    <select wire:model="subscription_plan_id" class="input-field">
                                        <option value="">Paket Seçin</option>
                                        @foreach($subscriptionPlans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }} ({{ number_format($plan->price, 2) }} TL — Limit: {{ $plan->student_limit ?: 'Sınırsız' }} Öğrenci)</option>
                                        @endforeach
                                    </select>
                                    @error('subscription_plan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_active" id="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Hesap Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="btn-primary">Kaydet</button>
                            <button type="button" wire:click="closeModal" class="btn-secondary">İptal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
