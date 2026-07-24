<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="text-purple-600 animate-pulse">⚡</span> Hızlı Program Hazırlama
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Öğrenci: <strong class="text-gray-900 font-semibold">{{ $student->name }}</strong>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('coach.students') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium text-gray-700 transition">
                İptal Et
            </a>
            <button wire:click="saveSchedule" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold text-sm shadow-md flex items-center gap-2 transition transform hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Programı Kaydet ve Gönder
            </button>
        </div>
    </div>

    <!-- Error/Success Alerts -->
    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT COLUMN: Weekday selector tabs & Course buttons (Takes 2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Days of the Week Navigation Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-3">1. GÜN SEÇİN</span>
                <div class="grid grid-cols-7 gap-1.5">
                    @php
                        $daysMap = [
                            1 => 'Pazartesi',
                            2 => 'Salı',
                            3 => 'Çarşamba',
                            4 => 'Perşembe',
                            5 => 'Cuma',
                            6 => 'Cumartesi',
                            7 => 'Pazar'
                        ];
                    @endphp
                    @foreach($daysMap as $dayNum => $dayName)
                        @php
                            $dayItemCount = collect($draftItems)->where('day_of_week', $dayNum)->count();
                        @endphp
                        <button type="button" 
                                wire:click="setActiveDay({{ $dayNum }})" 
                                wire:key="day-tab-{{ $dayNum }}"
                                class="py-2.5 rounded-xl text-xs font-bold border flex flex-col items-center justify-center transition-all duration-150 transform active:scale-95 {{ $activeDay === $dayNum ? 'bg-purple-600 border-purple-600 text-white shadow-md scale-105' : 'bg-gray-55/50 border-gray-200 text-gray-700 hover:bg-purple-50 hover:border-purple-200 hover:text-purple-700' }}">
                            <span>{{ $dayName }}</span>
                            @if($dayItemCount > 0)
                                <span class="mt-1 px-1.5 py-0.2 text-[9px] rounded-full {{ $activeDay === $dayNum ? 'bg-white text-purple-700 font-extrabold' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $dayItemCount }} ders
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Course Toggles Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-6 relative">
                <!-- Loading overlay -->
                <div wire:loading wire:target="setActiveDay, toggleCourseForActiveDay" 
                     class="absolute inset-0 bg-white/70 backdrop-blur-xs flex items-center justify-center z-10 rounded-xl transition duration-200">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-md border border-gray-100">
                        <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs font-semibold text-gray-700">Güncelleniyor...</span>
                    </div>
                </div>

                <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <span class="p-1 bg-purple-100 text-purple-700 rounded-md">⚡</span>
                        <span>{{ $daysMap[$activeDay] }} Günü Ders Planlaması</span>
                    </h3>
                    <span class="text-xs text-gray-400 italic">
                        * Derslerin üzerine tıklayarak aktif güne atayın veya kaldırın.
                    </span>
                </div>

                <!-- Grouped Course Toggles -->
                <div class="space-y-5">
                    @if(!empty($courses['tyt']) && count($courses['tyt']) > 0)
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest block">TYT Dersleri</span>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5">
                                @foreach($courses['tyt'] as $c)
                                    @php
                                        $isCourseActive = collect($draftItems)->where('course_id', $c->id)->where('day_of_week', $activeDay)->isNotEmpty();
                                    @endphp
                                    <button type="button" 
                                            wire:click="toggleCourseForActiveDay({{ $c->id }})" 
                                            wire:key="course-btn-tyt-{{ $c->id }}-day-{{ $activeDay }}"
                                            class="px-4 py-3 rounded-xl border text-xs font-bold text-left transition duration-150 transform active:scale-95 flex items-center justify-between {{ $isCourseActive ? 'bg-gradient-to-br from-purple-600 to-indigo-600 border-transparent text-white shadow-sm font-extrabold' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-purple-50 hover:border-purple-200' }}">
                                        <span>{{ $c->name }}</span>
                                        @if($isCourseActive)
                                            <span class="text-xs font-black">✓</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($courses['ayt']) && count($courses['ayt']) > 0)
                        <div class="pt-3 border-t border-gray-50 space-y-2">
                            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest block">AYT Dersleri</span>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5">
                                @foreach($courses['ayt'] as $c)
                                    @php
                                        $isCourseActive = collect($draftItems)->where('course_id', $c->id)->where('day_of_week', $activeDay)->isNotEmpty();
                                    @endphp
                                    <button type="button" 
                                            wire:click="toggleCourseForActiveDay({{ $c->id }})" 
                                            wire:key="course-btn-ayt-{{ $c->id }}-day-{{ $activeDay }}"
                                            class="px-4 py-3 rounded-xl border text-xs font-bold text-left transition duration-150 transform active:scale-95 flex items-center justify-between {{ $isCourseActive ? 'bg-gradient-to-br from-purple-600 to-indigo-600 border-transparent text-white shadow-sm font-extrabold' : 'bg-gray-55/50 border-gray-200 text-gray-700 hover:bg-purple-50 hover:border-purple-200' }}">
                                        <span>{{ $c->name }}</span>
                                        @if($isCourseActive)
                                            <span class="text-xs font-black">✓</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($courses['other']) && count($courses['other']) > 0)
                        <div class="pt-3 border-t border-gray-50 space-y-2">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block">Diğer Dersler</span>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5">
                                @foreach($courses['other'] as $c)
                                    @php
                                        $isCourseActive = collect($draftItems)->where('course_id', $c->id)->where('day_of_week', $activeDay)->isNotEmpty();
                                    @endphp
                                    <button type="button" 
                                            wire:click="toggleCourseForActiveDay({{ $c->id }})" 
                                            wire:key="course-btn-other-{{ $c->id }}-day-{{ $activeDay }}"
                                            class="px-4 py-3 rounded-xl border text-xs font-bold text-left transition duration-150 transform active:scale-95 flex items-center justify-between {{ $isCourseActive ? 'bg-gradient-to-br from-purple-600 to-indigo-600 border-transparent text-white shadow-sm font-extrabold' : 'bg-gray-55/50 border-gray-200 text-gray-700 hover:bg-purple-50 hover:border-purple-200' }}">
                                        <span>{{ $c->name }}</span>
                                        @if($isCourseActive)
                                            <span class="text-xs font-black">✓</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Program Details & Weekly Preview Summary (Takes 1/3 width) -->
        <div class="space-y-6 lg:col-span-1">
            <!-- Program Configuration Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="p-1.5 bg-blue-100 text-blue-600 rounded-lg text-xs">⚙️</span>
                    Program Bilgileri
                </h3>

                <div class="space-y-3">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Program Adı *</label>
                        <input type="text" wire:model="scheduleName" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('scheduleName') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Hafta No</label>
                        <input type="number" wire:model="weekNumber" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent" min="1">
                        @error('weekNumber') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Başlangıç Tarihi</label>
                        <input type="date" wire:model="startDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('startDate') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Bitiş Tarihi</label>
                        <input type="date" wire:model="endDate" min="{{ $startDate }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('endDate') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Weekly Summary list -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg text-xs">📅</span>
                        Haftalık Program Taslağı
                    </span>
                    <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">
                        {{ count($draftItems) }} Ders
                    </span>
                </h3>

                @error('draftItems')
                    <div class="bg-red-50 text-red-800 border border-red-200 p-3 rounded-lg text-xs font-semibold">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Weekly Summary Vertical List -->
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
                    @foreach($daysMap as $dayNum => $dayName)
                        @php
                            $dayDrafts = collect($this->draftItems)->where('day_of_week', $dayNum);
                        @endphp
                        <div wire:key="summary-day-{{ $dayNum }}" class="border border-gray-100 rounded-lg p-2.5 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-1.5">
                                <h4 class="text-xs font-bold text-gray-800 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                    {{ $dayName }}
                                </h4>
                            </div>

                            @if($dayDrafts->isEmpty())
                                <div class="text-[10px] text-gray-400 italic px-1">
                                    Ders atanmadı.
                                </div>
                            @else
                                <div class="flex flex-wrap gap-1">
                                    @foreach($dayDrafts as $item)
                                        <div wire:key="summary-item-{{ $item['temp_id'] }}" 
                                             class="bg-white border border-gray-150 rounded-lg px-2 py-1 flex items-center gap-1.5 shadow-xs">
                                            <span class="text-xs font-bold text-gray-900">
                                                {{ $item['course_name'] }}
                                            </span>
                                            <button type="button" 
                                                    wire:click="removeFromDraft('{{ $item['temp_id'] }}')" 
                                                    wire:key="remove-btn-{{ $item['temp_id'] }}"
                                                    class="text-red-400 hover:text-red-600 hover:bg-red-50 p-0.5 rounded transition" 
                                                    title="Kaldır">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
