<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="text-purple-600">⚡</span> Hızlı Program Hazırlama
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Öğrenci: <strong class="text-gray-900 font-semibold">{{ $student->name }}</strong> ({{ $student->email }})
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('coach.students') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium text-gray-700 transition">
                İptal Et
            </a>
            <button wire:click="saveSchedule" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold text-sm shadow-md flex items-center gap-2 transition transform hover:scale-[1.02]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Programı Kaydet ve Gönder
            </button>
        </div>
    </div>

    <!-- Error/Success Alerts -->
    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT COLUMN: Task Composer -->
        <div class="space-y-6 lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                    <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                        <span class="p-1.5 bg-purple-100 text-purple-600 rounded-lg text-xs">🚀</span>
                        Görev Oluşturucu
                    </h3>
                    @if (session()->has('draft_success'))
                        <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded-full animate-bounce">
                            {{ session('draft_success') }}
                        </span>
                    @endif
                </div>

                <!-- Course Select -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Ders Seçimi *</label>
                    <select wire:model.live="selectedCourseId" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50">
                        <option value="">-- Ders Seçin --</option>
                        @if(!empty($courses['tyt']) && count($courses['tyt']) > 0)
                            <optgroup label="TYT DERSLERİ">
                                @foreach($courses['tyt'] as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(!empty($courses['ayt']) && count($courses['ayt']) > 0)
                            <optgroup label="AYT DERSLERİ">
                                @foreach($courses['ayt'] as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if(!empty($courses['other']) && count($courses['other']) > 0)
                            <optgroup label="DİĞER DERSLER">
                                @foreach($courses['other'] as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    @error('selectedCourseId') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Topic Select -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Konu Seçimi *</label>
                    <select wire:model.live="selectedTopicId" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50" @disabled(empty($selectedCourseId))>
                        <option value="">-- Önce Ders Seçin --</option>
                        @foreach($topics as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedTopicId') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Sub-Topic Select -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Alt Başlık Seçimi (İsteğe Bağlı)</label>
                    <select wire:model="selectedSubTopicId" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50" @disabled(empty($selectedTopicId))>
                        <option value="">Tüm Alt Başlıklar</option>
                        @foreach($subTopics as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedSubTopicId') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Questions & Time Slot Row -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Soru Sayısı</label>
                        <input type="number" wire:model="questionCount" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50" min="0">
                        @error('questionCount') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    @if($scheduleType === 'timed')
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Saat Dilimi</label>
                            <select wire:model="timeSlot" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50">
                                @foreach($timeSlots as $slot)
                                    <option value="{{ $slot }}">{{ $slot }}</option>
                                @endforeach
                            </select>
                            @error('timeSlot') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Açıklama / Not</label>
                    <textarea wire:model="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50" placeholder="Örn: Konu tekrarı yapılacak ve testler çözülecek."></textarea>
                    @error('description') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Target Days Checklist -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Görevin Ekleneceği Günler *</label>
                    @error('selectedDays') <div class="text-xs text-red-600 font-semibold">{{ $message }}</div> @enderror
                    <div class="grid grid-cols-2 gap-2">
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
                        @foreach($daysMap as $num => $name)
                            <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 hover:bg-purple-50 hover:border-purple-200 cursor-pointer transition select-none">
                                <input type="checkbox" wire:model="selectedDays" value="{{ $num }}" class="rounded text-purple-600 focus:ring-purple-500 border-gray-300">
                                <span class="text-sm font-medium text-gray-700">{{ $name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Add Button -->
                <button type="button" wire:click="addToDraft" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold text-sm shadow-sm flex items-center justify-center gap-1.5 transition">
                    <span>⚡ Taslağa Görev Ekle</span>
                </button>
            </div>
        </div>

        <!-- RIGHT COLUMN: Metadata & Weekly Preview -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Program Configuration Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="p-1.5 bg-blue-100 text-blue-600 rounded-lg text-xs">⚙️</span>
                    Program Bilgileri
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Program Adı *</label>
                        <input type="text" wire:model="scheduleName" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('scheduleName') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Hafta No</label>
                            <input type="number" wire:model="weekNumber" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent" min="1">
                            @error('weekNumber') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Program Tipi</label>
                            <select wire:model.live="scheduleType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-gray-50">
                                <option value="daily">Saatsiz (Günlük)</option>
                                <option value="timed">Saatli (Haftalık)</option>
                            </select>
                            @error('scheduleType') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Başlangıç Tarihi</label>
                        <input type="date" wire:model="startDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('startDate') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Bitiş Tarihi</label>
                        <input type="date" wire:model="endDate" min="{{ $startDate }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('endDate') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Weekly Draft Preview Grid -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
                <h3 class="text-md font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="p-1.5 bg-indigo-100 text-indigo-600 rounded-lg text-xs">📅</span>
                        Haftalık Program Taslağı Önizleme
                    </span>
                    <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">
                        {{ count($draftItems) }} Görev
                    </span>
                </h3>

                @error('draftItems')
                    <div class="bg-red-50 text-red-800 border border-red-200 p-3 rounded-lg text-sm font-semibold">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Weekly Columns Layout -->
                <div class="space-y-4">
                    @foreach($daysMap as $dayNum => $dayName)
                        @php
                            $dayDrafts = collect($this->draftItems)->where('day_of_week', $dayNum);
                        @endphp
                        <div class="border border-gray-100 rounded-lg p-3 hover:shadow-sm transition bg-gray-50/50">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-1.5 mb-2">
                                <h4 class="text-sm font-bold text-gray-900 flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                    {{ $dayName }}
                                </h4>
                                <span class="text-xs text-gray-500 font-semibold bg-gray-100 px-2 py-0.5 rounded-full">
                                    {{ $dayDrafts->count() }} Görev
                                </span>
                            </div>

                            @if($dayDrafts->isEmpty())
                                <div class="text-xs text-gray-400 italic py-2 px-1">
                                    Bugün için henüz ders planlanmadı.
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($dayDrafts as $item)
                                        <div class="bg-white border border-gray-200 rounded-lg p-2.5 flex items-start justify-between shadow-xs hover:border-purple-300 transition group">
                                            <div class="space-y-1 flex-1 min-w-0 pr-2">
                                                <div class="flex items-center gap-1.5 flex-wrap">
                                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-[10px] font-bold uppercase">
                                                        {{ $item['course_name'] }}
                                                    </span>
                                                    @if($item['time_slot'])
                                                        <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[10px] font-semibold">
                                                            🕐 {{ $item['time_slot'] }}
                                                        </span>
                                                    @endif
                                                    @if($item['question_count'] > 0)
                                                        <span class="text-[11px] font-semibold text-gray-600 bg-gray-50 px-1.5 py-0.5 rounded">
                                                            ✍️ {{ $item['question_count'] }} Soru
                                                        </span>
                                                    @endif
                                                </div>
                                                <h5 class="text-xs font-semibold text-gray-900 truncate">
                                                    {{ $item['topic_name'] }}
                                                </h5>
                                                @if($item['sub_topic_id'])
                                                    <p class="text-[10px] text-gray-500 truncate">
                                                        {{ $item['sub_topic_name'] }}
                                                    </p>
                                                @endif
                                                @if($item['description'])
                                                    <p class="text-[10px] text-gray-600 bg-gray-50/50 p-1 rounded italic line-clamp-2">
                                                        {{ $item['description'] }}
                                                    </p>
                                                @endif
                                            </div>
                                            <button type="button" wire:click="removeFromDraft('{{ $item['temp_id'] }}')" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded-md transition-all" title="Görevi Kaldır">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
