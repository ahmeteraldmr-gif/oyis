<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kurum (Okul / Merkez) Yönetimi</h2>
            <p class="text-sm text-gray-600 mt-1">Sistemdeki tüm kurumları (adminleri) yönetin ve izleyin</p>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kurum Bilgileri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İletişim
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-accent-blue flex items-center justify-center text-white font-medium">
                                            {{ substr($admin->name, 0, 1) }}
                                        </div>
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
                            <td class="px-6 py-4">
                                @if($admin->subscription)
                                    <div class="text-sm text-gray-900 font-medium text-blue-600">{{ $admin->subscription->plan->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        Limit: {{ $admin->subscription->plan->student_limit ?: 'Sınırsız' }} Öğrenci
                                    </div>
                                @else
                                    <span class="text-xs text-red-600">Abonelik Yok</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button 
                                    wire:click="toggleStatus({{ $admin->id }})"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors {{ $admin->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                >
                                    {{ $admin->is_active ? 'Aktif' : 'Pasif' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button wire:click="edit({{ $admin->id }})" class="text-blue-600 hover:text-blue-900">
                                        Düzenle
                                    </button>
                                    <button 
                                        wire:click="delete({{ $admin->id }})" 
                                        onclick="confirm('Bu kurumu silmek istediğinizden emin misiniz? Kuruma bağlı tüm kullanıcılar silinecektir!') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Sil
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
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
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                                            <option value="{{ $plan->id }}">{{ $plan->name }} ({{ number_format($plan->price, 2) }} TL - Limit: {{ $plan->student_limit ?: 'Sınırsız' }} Öğrenci)</option>
                                        @endforeach
                                    </select>
                                    @error('subscription_plan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="is_active" id="is_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Hesap Aktif
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="btn-primary">
                                Kaydet
                            </button>
                            <button type="button" wire:click="closeModal" class="btn-secondary">
                                İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
