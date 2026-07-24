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
        <!-- LEFT COLUMN: Course Tabs & Topics Grid (Takes 2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Grouped Course Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span>📚</span> Ders Seçimi (Konuları görmek için tıklayın)
                </h3>

                <div class="space-y-4">
                    @if(!empty($courses['tyt']) && count($courses['tyt']) > 0)
                        <div>
                            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-widest block mb-2">TYT Dersleri</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($courses['tyt'] as $c)
                                    <button type="button" wire:click="selectCourse({{ $c->id }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $selectedCourseId == $c->id ? 'bg-purple-600 border-purple-600 text-white shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-purple-50 hover:border-purple-200 hover:text-purple-700' }}">
                                        {{ $c->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($courses['ayt']) && count($courses['ayt']) > 0)
                        <div class="pt-2 border-t border-gray-50">
                            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest block mb-2">AYT Dersleri</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($courses['ayt'] as $c)
                                    <button type="button" wire:click="selectCourse({{ $c->id }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $selectedCourseId == $c->id ? 'bg-indigo-600 border-indigo-600 text-white shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-700' }}">
                                        {{ $c->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($courses['other']) && count($courses['other']) > 0)
                        <div class="pt-2 border-t border-gray-50">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block mb-2">Diğer Dersler</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($courses['other'] as $c)
                                    <button type="button" wire:click="selectCourse({{ $c->id }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition {{ $selectedCourseId == $c->id ? 'bg-blue-600 border-blue-600 text-white shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700' }}">
                                        {{ $c->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Topics Grid Table -->
            @if($selectedCourseId)
                @php
                    $activeCourse = collect($courses)->flatten()->firstWhere('id', $selectedCourseId);
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-wrap gap-2">
                        <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                            <span class="p-1 bg-purple-100 text-purple-700 rounded-md">⚡</span>
                            <span>{{ $activeCourse ? $activeCourse->name : '' }} Konu Listesi</span>
                        </h3>
                        <span class="text-xs text-gray-500 italic">
                            * Gün dairelerine tıklayarak anında program taslağına ekleyin veya kaldırın.
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-sm">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="py-2.5 pr-4">Konu Adı</th>
                                    <th class="py-2.5 px-3 text-center" style="width: 100px;">Soru Sayısı</th>
                                    <th class="py-2.5 pl-4 text-center">Görevi Ekleneceği Günler (Tıkla - Tanımla)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($topics as $topic)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-3.5 pr-4 font-semibold text-gray-900">
                                            {{ $topic->name }}
                                        </td>
                                        <td class="py-3.5 px-3">
                                            <input type="number" 
                                                   wire:model.live.debounce.300ms="questionCountsByTopic.{{ $topic->id }}" 
                                                   class="w-20 text-center border border-gray-300 rounded-lg px-2 py-1 text-xs font-bold focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50/50"
                                                   min="0"
                                                   title="Varsayılan Soru Sayısı">
                                        </td>
                                        <td class="py-3.5 pl-4">
                                            <div class="flex items-center justify-center gap-1.5">
                                                @php
                                                    $daysConfig = [
                                                        1 => 'Pzt',
                                                        2 => 'Sal',
                                                        3 => 'Çar',
                                                        4 => 'Per',
                                                        5 => 'Cum',
                                                        6 => 'Cmt',
                                                        7 => 'Paz'
                                                    ];
                                                @endphp
                                                @foreach($daysConfig as $dayNum => $dayLabel)
                                                    @php
                                                        $isDayActive = collect($draftItems)->where('topic_id', $topic->id)->where('day_of_week', $dayNum)->isNotEmpty();
                                                    @endphp
                                                    <button type="button" 
                                                            wire:click="toggleDayForTopic({{ $topic->id }}, {{ $dayNum }})"
                                                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition duration-150 transform hover:scale-105 active:scale-95 {{ $isDayActive ? 'bg-gradient-to-br from-purple-600 to-indigo-600 text-white shadow-xs font-extrabold scale-105 border-transparent' : 'bg-gray-100 hover:bg-purple-100 hover:text-purple-700 text-gray-600 border border-gray-200' }}"
                                                            title="{{ $dayLabel }} günü için bu konuyu programla">
                                                        {{ $dayLabel }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-gray-400 italic">
                                            Bu derse ait aktif konu bulunamadı.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Program Details & Weekly Preview (Takes 1/3 width) -->
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

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Hafta No</label>
                            <input type="number" wire:model="weekNumber" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent" min="1">
                            @error('weekNumber') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Program Tipi</label>
                            <select wire:model.live="scheduleType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-semibold focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50">
                                <option value="daily">Saatsiz (Günlük)</option>
                                <option value="timed">Saatli (Haftalık)</option>
                            </select>
                            @error('scheduleType') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
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

            <!-- Weekly Draft Preview list -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg text-xs">📅</span>
                        Program Taslağı
                    </span>
                    <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full">
                        {{ count($draftItems) }} Görev
                    </span>
                </h3>

                @error('draftItems')
                    <div class="bg-red-50 text-red-800 border border-red-200 p-3 rounded-lg text-xs font-semibold">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Weekly Columns List (1 Column vertical stack) -->
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
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
                            $dayDrafts = collect($this->draftItems)->where('day_of_week', $dayNum);
                        @endphp
                        <div class="border border-gray-100 rounded-lg p-2.5 bg-gray-50/50">
                            <div class="flex items-center justify-between mb-1.5">
                                <h4 class="text-xs font-bold text-gray-800 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                    {{ $dayName }}
                                </h4>
                                <span class="text-[10px] text-gray-500 font-bold bg-white border px-1.5 py-0.2 rounded-full">
                                    {{ $dayDrafts->count() }}
                                </span>
                            </div>

                            @if($dayDrafts->isEmpty())
                                <div class="text-[10px] text-gray-400 italic px-1">
                                    Ders atanmadı.
                                </div>
                            @else
                                <div class="space-y-1.5">
                                    @foreach($dayDrafts as $item)
                                        <div class="bg-white border border-gray-100 rounded-md p-2 flex items-start justify-between shadow-xs">
                                            <div class="flex-1 min-w-0 pr-1 space-y-0.5">
                                                <div class="flex items-center gap-1 flex-wrap">
                                                    <span class="px-1 py-0.2 bg-blue-50 text-blue-700 rounded text-[9px] font-bold uppercase">
                                                        {{ $item['course_name'] }}
                                                    </span>
                                                    @if($item['question_count'] > 0)
                                                        <span class="text-[9px] font-bold text-gray-600 bg-gray-50 px-1 py-0.2 rounded">
                                                            ✍️ {{ $item['question_count'] }} Soru
                                                        </span>
                                                    @endif
                                                </div>
                                                <h5 class="text-xs font-semibold text-gray-900 truncate">
                                                    {{ $item['topic_name'] }}
                                                </h5>
                                            </div>
                                            <button type="button" wire:click="removeFromDraft('{{ $item['temp_id'] }}')" class="text-red-400 hover:text-red-600 hover:bg-red-50 p-0.5 rounded transition" title="Görevi kaldır">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
