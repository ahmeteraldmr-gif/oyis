<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Koç Yönetimi</h2>
            <p class="text-sm text-gray-600 mt-1">Tüm koçları yönetin ve izleyin</p>
        </div>
        <button wire:click="openModal" class="btn-primary">
            + Yeni Koç Ekle
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
                    placeholder="Koç adı veya e-posta ile ara..."
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

    <!-- Coaches Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Koç Bilgileri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İletişim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Öğrenci Sayısı
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Abonelik
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
                    @forelse($coaches as $coach)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-accent-blue flex items-center justify-center text-white font-medium">
                                            {{ substr($coach->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $coach->name }}</div>
                                        <div class="text-xs text-gray-500">Kayıt: {{ $coach->created_at->format('d.m.Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $coach->email }}</div>
                                <div class="text-xs text-gray-500">{{ $coach->phone ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ ($coach->subscription?->student_limit && $coach->students->count() >= $coach->subscription->student_limit) ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $coach->students->count() }} / {{ $coach->subscription?->student_limit ?: 'Sınırsız' }} Öğrenci
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($coach->subscription && $coach->subscription->end_date)
                                    @php
                                        $remaining = \Carbon\Carbon::now()->diffInDays($coach->subscription->end_date, false);
                                        $isExpired = $remaining < 0 || !$coach->subscription->is_active;
                                    @endphp
                                    <div class="text-xs font-semibold {{ $isExpired ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $isExpired ? '🔴 Süresi Doldu' : '🟢 '.$remaining.' gün kaldı' }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        Bitiş: {{ $coach->subscription->end_date->format('d.m.Y') }}
                                    </div>
                                @else
                                    <span class="text-xs font-medium text-green-600">Sınırsız / Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button 
                                    wire:click="toggleStatus({{ $coach->id }})"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coach->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                >
                                    {{ $coach->is_active ? 'Aktif' : 'Pasif' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    wire:click="edit({{ $coach->id }})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3"
                                >
                                    Düzenle
                                </button>
                                <button 
                                    wire:click="delete({{ $coach->id }})" 
                                    onclick="return confirm('Bu koçu silmek istediğinize emin misiniz?')"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Sil
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Henüz koç bulunmamaktadır.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $coaches->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
            <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white" wire:click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $editMode ? 'Koç & Abonelik Düzenle' : 'Yeni Koç Ekle' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="save" class="mt-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                İsim Soyisim *
                            </label>
                            <input 
                                type="text" 
                                wire:model="name" 
                                class="input-field"
                                placeholder="Ahmet Yılmaz"
                            >
                            @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                E-posta *
                            </label>
                            <input 
                                type="email" 
                                wire:model="email" 
                                class="input-field"
                                placeholder="ornek@email.com"
                            >
                            @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Şifre {{ $editMode ? '(Boş bırakılırsa değişmez)' : '*' }}
                            </label>
                            <input 
                                type="password" 
                                wire:model="password" 
                                class="input-field"
                                placeholder="••••••••"
                            >
                            @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Telefon
                            </label>
                            <input 
                                type="text" 
                                wire:model="phone" 
                                class="input-field"
                                placeholder="0555 555 55 55"
                            >
                            @error('phone') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- ABONELİK SÜRESİ (GÜN) -->
                        <div class="bg-indigo-50/60 border border-indigo-100 rounded-xl p-3">
                            <label class="block text-sm font-bold text-indigo-900 mb-1">
                                📅 Abonelik Süresi (Gün Sayısı) *
                            </label>
                            <input 
                                type="number" 
                                wire:model="duration_days" 
                                min="1"
                                max="3650"
                                class="input-field bg-white"
                                placeholder="Örn: 30"
                            >
                            <p class="text-[11px] text-indigo-600 mt-1">Giriş anından itibaren tanımlanacak süre (gün)</p>
                            @error('duration_days') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <!-- MAKSİMUM ÖĞRENCİ LİMİTİ -->
                        <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-3">
                            <label class="block text-sm font-bold text-blue-900 mb-1">
                                👥 Öğrenci Kontenjanı (Max Limiti)
                            </label>
                            <input 
                                type="number" 
                                wire:model="student_limit" 
                                min="1"
                                class="input-field bg-white"
                                placeholder="Örn: 20 (Boş ise sınırsız)"
                            >
                            <p class="text-[11px] text-blue-600 mt-1">Koçun ekleyebileceği maks öğrenci sayısı</p>
                            @error('student_limit') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    wire:model="is_active" 
                                    class="h-4 w-4 text-accent-blue focus:ring-accent-blue border-gray-300 rounded"
                                >
                                <span class="ml-2 text-sm text-gray-700 font-medium">Koç Hesabı Aktif Olsun</span>
                            </label>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                        <button type="button" wire:click="closeModal" class="btn-secondary">
                            İptal
                        </button>
                        <button type="submit" class="btn-primary">
                            {{ $editMode ? 'Güncelle' : 'Kaydet' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
