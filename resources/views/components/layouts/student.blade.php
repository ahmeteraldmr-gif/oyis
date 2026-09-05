<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Öğrenci Panel' }} - Öğrenci Takip Sistemi</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@php
    $studentUser = auth()->user();
    
    // Aktif haftalık programdaki görev sayısı
    $activeSchedule = \App\Models\StudySchedule::where('student_id', $studentUser->id)
        ->where('is_active', true)
        ->latest('id')
        ->first();
        
    $pendingScheduleItemsCount = 0;
    if ($activeSchedule) {
        $completedScheduleItemIds = \App\Models\ScheduleProgress::where('student_id', $studentUser->id)
            ->where('status', 'completed')
            ->pluck('schedule_item_id');
            
        $pendingScheduleItemsCount = $activeSchedule->items()
            ->whereNotIn('id', $completedScheduleItemIds)
            ->count();
    }
    
    // Tamamlanmamış ders atamaları sayısı
    $pendingAssignmentsCount = \App\Models\StudentAssignment::where('student_id', $studentUser->id)
        ->whereDoesntHave('progress', function($q) {
            $q->where('is_completed', true);
        })
        ->count();
        
    // Atanan kaynak sayısı
    $assignedResourcesCount = \App\Models\StudentResource::where('student_id', $studentUser->id)->count();

    // Toplam bildirim sayısı
    $totalNotificationCount = $pendingScheduleItemsCount + $pendingAssignmentsCount;
@endphp

<body class="bg-secondary-50 antialiased" x-data="{ mobileOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Header Bar -->
        <div class="md:hidden fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-3">
                <button @click="mobileOpen = true" type="button" class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-bold text-accent-blue">Öğrenci Paneli</h1>
            </div>
            <div class="flex items-center space-x-3">
                @if($totalNotificationCount > 0)
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                @endif
                <div class="h-8 w-8 rounded-full bg-accent-blue flex items-center justify-center text-white font-bold text-xs">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Mobile Backdrop -->
        <div x-show="mobileOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileOpen = false" 
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 md:hidden" 
             style="display: none;"></div>

        <!-- Mobile Sidebar Drawer -->
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-72 bg-white z-50 shadow-2xl flex flex-col md:hidden" 
             style="display: none;">
            
            <div class="flex items-center justify-between px-4 pt-5 pb-3 border-b border-gray-100">
                <h1 class="text-xl font-bold text-accent-blue">Öğrenci Paneli</h1>
                <button @click="mobileOpen = false" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-4 bg-primary-50 mx-4 my-3 rounded-xl flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-accent-blue flex items-center justify-center text-white font-bold flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">
                <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('student.courses') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Derslerim
                    </div>
                    @if($pendingAssignmentsCount > 0)
                        <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-indigo-100 text-indigo-800">
                            {{ $pendingAssignmentsCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('student.schedule') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Haftalık Programım
                    </div>
                    @if($pendingScheduleItemsCount > 0)
                        <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-red-100 text-red-700">
                            {{ $pendingScheduleItemsCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('student.resources') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.resources') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Kaynaklarım
                    </div>
                    @if($assignedResourcesCount > 0)
                        <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                            {{ $assignedResourcesCount }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('student.questions') }}" class="sidebar-link {{ request()->routeIs('student.questions') ? 'active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Soru Takibi
                </a>
                
                <a href="{{ route('student.exams') }}" class="sidebar-link {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Deneme Takibi
                </a>
                
                <a href="{{ route('student.study') }}" class="sidebar-link {{ request()->routeIs('student.study') ? 'active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Çalışma Takibi
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-600 hover:bg-red-50 flex items-center">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Çıkış Yap
                    </button>
                </form>
            </div>
        </div>

        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow bg-white border-r border-gray-200 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4 mb-5">
                        <h1 class="text-2xl font-bold text-accent-blue">Öğrenci Paneli</h1>
                    </div>
                    
                    <div class="px-4 mb-6">
                        <div class="flex items-center space-x-3 p-3 bg-primary-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-accent-blue flex items-center justify-center text-white font-medium">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <nav class="flex-1 px-2 space-y-1">
                        <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('student.courses') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Derslerim
                            </div>
                            @if($pendingAssignmentsCount > 0)
                                <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $pendingAssignmentsCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('student.schedule') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Haftalık Programım
                            </div>
                            @if($pendingScheduleItemsCount > 0)
                                <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                    {{ $pendingScheduleItemsCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('student.resources') }}" class="sidebar-link flex items-center justify-between {{ request()->routeIs('student.resources') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Kaynaklarım
                            </div>
                            @if($assignedResourcesCount > 0)
                                <span class="py-0.5 px-2 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                    {{ $assignedResourcesCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('student.questions') }}" class="sidebar-link {{ request()->routeIs('student.questions') ? 'active' : '' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Soru Takibi
                        </a>
                        
                        <a href="{{ route('student.exams') }}" class="sidebar-link {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Deneme Takibi
                        </a>
                        
                        <a href="{{ route('student.study') }}" class="sidebar-link {{ request()->routeIs('student.study') ? 'active' : '' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Çalışma Takibi
                        </a>
                        
                        <a href="{{ route('student.progress') }}" class="sidebar-link {{ request()->routeIs('student.progress') ? 'active' : '' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            İlerlemem
                        </a>
                    </nav>
                    
                    <div class="px-2 mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-link w-full text-left text-red-600 hover:bg-red-50">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Çıkış Yap
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden pt-14 md:pt-0">
            <!-- Top Header Bar with Notifications Bell -->
            <div class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between shadow-sm z-10">
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-gray-700">
                        Hoş Geldin, <span class="text-indigo-600 font-bold">{{ auth()->user()->name }}</span> 👋
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell Button -->
                    <a href="{{ route('student.schedule') }}" class="relative p-2 text-gray-600 hover:text-indigo-600 transition flex items-center gap-1 text-xs font-semibold bg-gray-50 hover:bg-indigo-50 border border-gray-200 rounded-lg" title="Bildirimler & Bekleyen Görevler">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span>Bildirimler</span>
                        @if($totalNotificationCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-extrabold leading-none text-white bg-red-600 rounded-full shadow animate-pulse">
                                {{ $totalNotificationCount > 99 ? '99+' : $totalNotificationCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>

