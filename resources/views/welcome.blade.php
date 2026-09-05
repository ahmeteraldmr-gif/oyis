<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RehberKoçum - Akıllı Öğrenci Takip ve Eğitim Koçluğu Platformu</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN for instant dynamic compilation -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        accent: {
                            blue: '#4f46e5',
                            green: '#10b981',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF9F6;
        }
        h1, h2, h3, h4, .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .hero-gradient {
            background: radial-gradient(circle at 85% 15%, rgba(79, 70, 229, 0.08) 0%, rgba(255, 255, 255, 0) 50%),
                        radial-gradient(circle at 15% 85%, rgba(16, 185, 129, 0.08) 0%, rgba(255, 255, 255, 0) 50%);
        }
        .glass-header {
            backdrop-filter: blur(16px);
            background-color: rgba(250, 249, 246, 0.85);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }
        .premium-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07);
            border-color: rgba(79, 70, 229, 0.3);
        }
        .demo-btn {
            border: none !important;
            transition: all 0.2s ease;
        }
        .demo-btn:hover {
            transform: scale(1.02);
            filter: brightness(0.95);
        }
        .text-gradient {
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        form {
            display: block;
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-between hero-gradient text-slate-800">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 glass-header w-full">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-2xl font-black tracking-tight text-slate-900">
                    rehber<span class="text-indigo-600">koçum</span>
                </span>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#nedir" class="hover:text-indigo-600 transition">Nedir?</a>
                <a href="#neden-var" class="hover:text-indigo-600 transition">Neden RehberKoçum?</a>
                <a href="#ozellikler" class="hover:text-indigo-600 transition">Özellikler</a>
                <a href="#nasil-calisir" class="hover:text-indigo-600 transition">Nasıl Çalışır?</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 bg-white rounded-xl text-sm font-bold hover:bg-slate-50 transition shadow-sm" style="text-decoration: none;">
                    Giriş Yap
                </a>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-6 py-12 md:py-20 space-y-24">
        
        <!-- Hero Section -->
        <section class="max-w-4xl mx-auto text-center space-y-8 py-6">
            <!-- Hero Text -->
            <div class="space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm mx-auto">
                    ⚡ Yapay Zeka Destekli & Akıllı Koçluk Platformu
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
                    Öğrencilerinizi <br>
                    <span class="text-gradient">Akıllı İlerleme</span> ile Takip Edin
                </h1>
                <p class="text-base md:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Sınava hazırlanan öğrenciler için ders, konu analizi, günlük soru takibi ve deneme gelişimlerini tek bir akıllı platformdan yönetin. Koçluk verimliliğinizi 3 katına çıkarın.
                </p>
            </div>

            <!-- CTA Button -->
            <div class="pt-4">
                <a href="{{ route('login') }}" 
                   class="inline-block px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-base font-extrabold shadow-lg shadow-indigo-200 transition-all hover:scale-105" style="text-decoration: none;">
                    Sisteme Giriş Yap ➜
                </a>
            </div>
        </section>

        <!-- Nedir Section (separation/ne işe yarar) -->
        <section id="nedir" class="space-y-12">
            <div class="text-center space-y-4 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">RehberKoçum Ne İşe Yarar?</h2>
                <p class="text-slate-600">RehberKoçum, eğitim koçları ile sınava hazırlanan öğrenciler arasındaki iletişimi dijitalleştiren ve hızlandıran akıllı bir takip platformudur.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="premium-card p-6 rounded-3xl">
                    <div class="text-3xl mb-4">🎯</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hassas Takip Yolu</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Öğrencinizin hangi dersten, hangi konuyu ve alt konuyu tamamladığını basamak basamak görün, eksik noktaları tespit edin.</p>
                </div>
                <!-- Card 2 -->
                <div class="premium-card p-6 rounded-3xl">
                    <div class="text-3xl mb-4">⚡</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hızlı Program Yapımı</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Saatlik ya da serbest çalışma hedefleri koyarak dakikalar içinde haftalık çalışma programı oluşturun ve öğrenciye atayın.</p>
                </div>
                <!-- Card 3 -->
                <div class="premium-card p-6 rounded-3xl">
                    <div class="text-3xl mb-4">📊</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">TYT / AYT Analizleri</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Deneme sınav sonuçlarını net, doğru ve yanlış sayılarıyla takip edin. Gelişimi sekmeli grafiklerle anında analiz edin.</p>
                </div>
                <!-- Card 4 -->
                <div class="premium-card p-6 rounded-3xl">
                    <div class="text-3xl mb-4">📄</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">PDF Raporlama</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Tek tıklamayla tüm deneme gelişim verilerini ve ders ortalamalarını barındıran Türkçe karakter uyumlu PDF çıktısını alın.</p>
                </div>
            </div>
        </section>

        <!-- Neden RehberKoçum Var Section (Neden Varız?) -->
        <section id="neden-var" class="bg-indigo-900 text-white rounded-3xl p-8 md:p-12 shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center gap-8 justify-between">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_120%,rgba(99,102,241,0.35),transparent_70%)]"></div>
            <div class="space-y-4 max-w-2xl z-10">
                <span class="text-xs font-bold tracking-widest text-indigo-300 uppercase">Biz Neden Varız?</span>
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">Geleneksel, Dağınık Takip Sistemlerine Son Vermek İçin</h2>
                <p class="text-sm md:text-base text-indigo-100/90 leading-relaxed">
                    Sınava hazırlık süreci karmaşık ve streslidir. Koçların ve kurumların öğrencileri WhatsApp mesajları, Excel dosyaları veya fiziksel ajandalar üzerinden takip etmesi büyük zaman kaybına ve kritik bilgilerin kaçmasına yol açar. RehberKoçum, her şeyi tek bir bulut tabanlı merkezde birleştirerek koçların işini otomatikleştirir, öğrencilere ise verilerle desteklenmiş bir yol haritası sunar.
                </p>
            </div>
            <div class="z-10 flex-shrink-0 bg-indigo-800/80 backdrop-blur border border-indigo-700 p-6 rounded-2xl space-y-3 w-full md:w-80">
                <h4 class="text-sm font-bold text-indigo-200 uppercase tracking-wider">Geliştirme Amacımız</h4>
                <ul class="text-xs space-y-2 text-indigo-100">
                    <li class="flex items-center gap-2">🟢 Kağıt/Excel dağınıklığını önlemek</li>
                    <li class="flex items-center gap-2">🟢 Öğrenciyi verilerle motive etmek</li>
                    <li class="flex items-center gap-2">🟢 Koçların raporlama süresini azaltmak</li>
                    <li class="flex items-center gap-2">🟢 Net hedeflerle başarı oranını artırmak</li>
                </ul>
            </div>
        </section>

        <!-- Detaylı Özellikler (Core Features) -->
        <section id="ozellikler" class="space-y-12">
            <div class="text-center space-y-4 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Güçlü Eğitim Altyapısı</h2>
                <p class="text-slate-600">Hem koçun hem öğrencinin ihtiyaç duyduğu tüm araçlar en premium tasarımla bir arada.</p>
            </div>

            <div class="space-y-6">
                <!-- Feature 1 -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center gap-8">
                    <div class="p-4 bg-indigo-50 rounded-2xl text-4xl text-indigo-600 flex-shrink-0">📚</div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-slate-900">Konu & Müfredat Ağacı</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Sistemdeki tüm alanlar (Sayısal, Sözel, Eşit Ağırlık, Dil) altında dersler, konular ve alt konular olarak hiyerarşik yapıdadır. Öğrenci tamamladığı alt konuları işaretlediğinde koç bunu anlık olarak kendi panelinde görür.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center gap-8">
                    <div class="p-4 bg-emerald-50 rounded-2xl text-4xl text-emerald-600 flex-shrink-0">🗓️</div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-slate-900">Gelişmiş Program Sihirbazı</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Koçlar, öğrencilerine haftalık çalışma planları oluştururken saatli (09:00 - 10:30 gibi) veya serbest hedefli görevler oluşturabilir. Öğrenci gün içinde tamamladığı görevleri işaretledikçe koç gelişim oranını anlık olarak izleyebilir.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center gap-8">
                    <div class="p-4 bg-purple-50 rounded-2xl text-4xl text-purple-600 flex-shrink-0">📊</div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-slate-900">TYT/AYT Gelişim Grafikleri ve Karşılaştırma</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Gelişmiş sekmeli yapı sayesinde TYT ve AYT sınavları tamamen ayrıştırılır. En iyi netler, genel ders ortalamaları ve zaman içindeki gelişim grafikleri tek ekrandan izlenir. İki farklı deneme ders bazında yan yana karşılaştırılabilir.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== NASIL ÇALIŞIR? - Premium Animasyonlu Demo Bölümü ===== -->
        <section id="nasil-calisir">

            <!-- Section Header -->
            <div class="text-center space-y-3 max-w-3xl mx-auto mb-14">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-violet-50 text-violet-700 border border-violet-100">
                    🎬 İnteraktif Demo
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Nasıl Çalışır?</h2>
                <p class="text-slate-500 text-sm md:text-base leading-relaxed">Koçluk sürecini dijitalleştiren 4 adımı keşfedin.</p>
            </div>

            <!-- Main Demo Container -->
            <div class="max-w-5xl mx-auto flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-2xl" style="border: 1px solid rgba(99,102,241,0.25);">

                <!-- LEFT: Sidebar -->
                <div class="lg:w-60 flex-shrink-0 flex flex-row lg:flex-col" style="background:linear-gradient(160deg,#1e1b4b 0%,#0f172a 100%);">

                    <!-- Logo (desktop) -->
                    <div class="hidden lg:flex items-center gap-2 px-5 py-5 border-b border-white/10">
                        <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white text-xs font-black">R</div>
                        <span class="text-white font-black text-sm">rehber<span class="text-indigo-400">koçum</span></span>
                    </div>

                    <!-- Step buttons -->
                    <button type="button" id="dsb-0" onclick="demoGoTo(0)" class="demo-sb flex items-center gap-3 px-5 py-4 text-left w-full border-b lg:border-b border-white/10 border-r lg:border-r-0 flex-1 lg:flex-none relative" style="background:rgba(99,102,241,0.18);">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-sm font-black flex-shrink-0 shadow-lg">1</div>
                        <div class="hidden lg:block">
                            <div class="text-white text-xs font-bold">Öğrenci Ekle</div>
                            <div class="text-white/40 text-[10px]">Sisteme kayıt</div>
                        </div>
                        <div class="absolute right-0 top-0 bottom-0 w-0.5 bg-indigo-400 hidden lg:block"></div>
                    </button>

                    <button type="button" id="dsb-1" onclick="demoGoTo(1)" class="demo-sb flex items-center gap-3 px-5 py-4 text-left w-full border-b lg:border-b border-white/10 border-r lg:border-r-0 flex-1 lg:flex-none relative opacity-50">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/50 text-sm font-black flex-shrink-0">2</div>
                        <div class="hidden lg:block">
                            <div class="text-white/60 text-xs font-bold">Ders Ata</div>
                            <div class="text-white/30 text-[10px]">TYT & AYT konuları</div>
                        </div>
                    </button>

                    <button type="button" id="dsb-2" onclick="demoGoTo(2)" class="demo-sb flex items-center gap-3 px-5 py-4 text-left w-full border-b lg:border-b border-white/10 border-r lg:border-r-0 flex-1 lg:flex-none relative opacity-50">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/50 text-sm font-black flex-shrink-0">3</div>
                        <div class="hidden lg:block">
                            <div class="text-white/60 text-xs font-bold">Program Kur</div>
                            <div class="text-white/30 text-[10px]">Haftalık çizelge</div>
                        </div>
                    </button>

                    <button type="button" id="dsb-3" onclick="demoGoTo(3)" class="demo-sb flex items-center gap-3 px-5 py-4 text-left w-full border-r lg:border-r-0 flex-1 lg:flex-none relative opacity-50">
                        <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/50 text-sm font-black flex-shrink-0">4</div>
                        <div class="hidden lg:block">
                            <div class="text-white/60 text-xs font-bold">Gelişimi İzle</div>
                            <div class="text-white/30 text-[10px]">Analiz & raporlar</div>
                        </div>
                    </button>

                    <!-- Play button (desktop) -->
                    <div class="hidden lg:flex flex-col mt-auto border-t border-white/10 p-4 gap-3">
                        <button type="button" id="demo-play-btn" onclick="demoTogglePlay()" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-all shadow-lg">
                            <svg id="demo-pi" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <svg id="demo-pai" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" style="display:none;"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            <span id="demo-play-lbl">Otomatik Oynat</span>
                        </button>
                        <div class="flex justify-center gap-1.5">
                            <div id="dd0" class="h-1 rounded-full bg-indigo-400 transition-all duration-400" style="width:24px;"></div>
                            <div id="dd1" class="h-1 rounded-full bg-white/20 transition-all duration-400" style="width:8px;"></div>
                            <div id="dd2" class="h-1 rounded-full bg-white/20 transition-all duration-400" style="width:8px;"></div>
                            <div id="dd3" class="h-1 rounded-full bg-white/20 transition-all duration-400" style="width:8px;"></div>
                        </div>
                    </div>

                    <!-- Play button (mobile) -->
                    <div class="lg:hidden flex items-center px-3">
                        <button type="button" onclick="demoTogglePlay()" class="flex items-center gap-1 py-2 px-3 rounded-xl text-xs font-bold bg-indigo-600 text-white">
                            <svg id="demo-pi-m" class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <svg id="demo-pai-m" class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24" style="display:none;"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- RIGHT: Screen -->
                <div class="flex-1 flex flex-col" style="background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 100%);">

                    <!-- Fake browser bar -->
                    <div class="flex items-center gap-2 px-5 py-3 border-b border-white/10" style="background:rgba(255,255,255,0.03);">
                        <div class="flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/70"></div>
                        </div>
                        <div class="flex-1 mx-3 bg-white/10 rounded-md px-3 py-1 text-[11px] text-white/40 font-mono" id="demo-url">rehberkoçum.com/koc/ogrenciler</div>
                    </div>

                    <!-- Panels -->
                    <div class="relative flex-1" style="min-height:380px;">

                        <!-- Panel 0 -->
                        <div id="dpanel-0" class="absolute inset-0 p-6 md:p-8 flex flex-col gap-4" style="opacity:1;transition:opacity 0.5s;">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 rounded-full bg-indigo-500"></div>
                                <h3 class="text-white font-extrabold">Yeni Öğrenci Oluştur</h3>
                                <span class="ml-auto text-white/30 text-[10px] font-mono">koç › öğrenciler › yeni</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 flex-1">
                                <div class="md:col-span-3 bg-white/5 border border-white/10 rounded-2xl p-5 space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><div class="text-white/40 text-[10px] uppercase font-bold mb-1">Ad</div><div class="bg-white/10 border border-white/15 rounded-lg h-9 flex items-center px-3"><span class="text-white/70 text-xs">Ali</span><span class="w-0.5 h-4 bg-indigo-400 ml-0.5 animate-pulse"></span></div></div>
                                        <div><div class="text-white/40 text-[10px] uppercase font-bold mb-1">Soyad</div><div class="bg-white/10 border border-white/15 rounded-lg h-9 flex items-center px-3"><span class="text-white/70 text-xs">Yılmaz</span></div></div>
                                    </div>
                                    <div><div class="text-white/40 text-[10px] uppercase font-bold mb-1">E-posta</div><div class="bg-white/10 border border-white/15 rounded-lg h-9 flex items-center px-3"><span class="text-white/70 text-xs">ali.yilmaz@gmail.com</span></div></div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><div class="text-white/40 text-[10px] uppercase font-bold mb-1">Şifre</div><div class="bg-white/10 border border-white/15 rounded-lg h-9 flex items-center px-3"><span class="text-white/70 text-xs">••••••••</span></div></div>
                                        <div><div class="text-white/40 text-[10px] uppercase font-bold mb-1">Sınıf</div><div class="bg-white/10 border border-white/15 rounded-lg h-9 flex items-center px-3"><span class="text-white/70 text-xs">12. Sınıf</span></div></div>
                                    </div>
                                    <div class="h-10 bg-indigo-600 rounded-xl flex items-center justify-center gap-2 text-white text-xs font-extrabold shadow-lg shadow-indigo-900/50 mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Öğrenci Oluştur
                                    </div>
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <div class="text-white/40 text-[10px] uppercase font-bold tracking-wider mb-3">Kayıtlı Öğrenciler</div>
                                    <div class="bg-indigo-500/20 border border-indigo-400/40 rounded-xl p-3 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-black text-xs">AY</div>
                                        <div><div class="text-white text-xs font-semibold">Ali Yılmaz</div><div class="text-indigo-300 text-[10px]">Yeni eklendi ✓</div></div>
                                        <div class="ml-auto w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                    </div>
                                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 flex items-center gap-3 opacity-60">
                                        <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-black text-xs">ZK</div>
                                        <div><div class="text-white text-xs font-semibold">Zeynep Kara</div><div class="text-white/30 text-[10px]">aktif öğrenci</div></div>
                                    </div>
                                    <div class="bg-white/5 border border-white/10 rounded-xl p-3 flex items-center gap-3 opacity-40">
                                        <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white font-black text-xs">MB</div>
                                        <div><div class="text-white text-xs font-semibold">Mert Bulut</div><div class="text-white/30 text-[10px]">aktif öğrenci</div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 1 -->
                        <div id="dpanel-1" class="absolute inset-0 p-6 md:p-8 flex flex-col gap-4" style="opacity:0;transition:opacity 0.5s;pointer-events:none;">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 rounded-full bg-emerald-500"></div>
                                <h3 class="text-white font-extrabold">Ders & Konu Ataması</h3>
                                <span class="ml-auto text-white/30 text-[10px] font-mono">koç › Ali Yılmaz › dersler</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 flex-1">
                                <div class="bg-emerald-900/40 border border-emerald-500/30 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-3"><span class="text-emerald-400 text-[10px] font-black uppercase tracking-wider">TYT</span><span class="text-emerald-400 text-[10px] bg-emerald-400/20 px-1.5 py-0.5 rounded-full">4/5</span></div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-emerald-500 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><span class="text-white text-[11px]">Matematik</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-emerald-500 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><span class="text-white text-[11px]">Türkçe</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-emerald-500 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><span class="text-white text-[11px]">Fizik</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-white/20"></div><span class="text-white/40 text-[11px]">Kimya</span></div>
                                    </div>
                                </div>
                                <div class="bg-indigo-900/40 border border-indigo-500/30 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-3"><span class="text-indigo-400 text-[10px] font-black uppercase tracking-wider">AYT</span><span class="text-indigo-400 text-[10px] bg-indigo-400/20 px-1.5 py-0.5 rounded-full">3/6</span></div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-indigo-500 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><span class="text-white text-[11px]">Mat (AYT)</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-indigo-500 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div><span class="text-white text-[11px]">Fizik (AYT)</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-white/20 animate-pulse"></div><span class="text-white/50 text-[11px]">Kimya...</span></div>
                                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded-md bg-white/20"></div><span class="text-white/30 text-[11px]">Biyoloji</span></div>
                                    </div>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                                    <div class="text-white/40 text-[10px] uppercase font-bold tracking-wider mb-3">Atama Günlüğü</div>
                                    <div class="space-y-2.5">
                                        <div class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-1 flex-shrink-0"></div><div><div class="text-white text-[11px] font-semibold">Matematik - Limit</div><div class="text-white/30 text-[9px]">az önce</div></div></div>
                                        <div class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-1 flex-shrink-0"></div><div><div class="text-white text-[11px] font-semibold">Türkçe - Paragraf</div><div class="text-white/30 text-[9px]">2 dk önce</div></div></div>
                                        <div class="flex items-start gap-2"><div class="w-1.5 h-1.5 rounded-full bg-yellow-400 mt-1 flex-shrink-0 animate-pulse"></div><div><div class="text-white/60 text-[11px] font-semibold">Fizik - Kuvvet...</div><div class="text-yellow-400/60 text-[9px]">atanıyor...</div></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 2 -->
                        <div id="dpanel-2" class="absolute inset-0 p-6 md:p-8 flex flex-col gap-4" style="opacity:0;transition:opacity 0.5s;pointer-events:none;">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 rounded-full bg-purple-500"></div>
                                <h3 class="text-white font-extrabold">Haftalık Çalışma Programı</h3>
                                <span class="ml-auto flex items-center gap-1.5 text-purple-300 text-[10px] font-bold bg-purple-500/20 px-2.5 py-1 rounded-full"><span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>Ali Yılmaz için</span>
                            </div>
                            <div class="flex-1 overflow-auto">
                                <table class="w-full text-[11px] text-white border-collapse">
                                    <thead><tr>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/40 font-semibold text-left w-16">Saat</th>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/60 font-semibold text-center">Pzt</th>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/60 font-semibold text-center">Sal</th>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/60 font-semibold text-center">Çar</th>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/60 font-semibold text-center">Per</th>
                                        <th class="py-2 px-2 bg-white/5 border border-white/10 text-white/60 font-semibold text-center">Cum</th>
                                    </tr></thead>
                                    <tbody>
                                        <tr>
                                            <td class="py-2 px-2 border border-white/10 text-white/30">09:00</td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-indigo-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Matematik</div></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-emerald-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Türkçe</div></td>
                                            <td class="py-1 px-1 border border-white/10"></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-purple-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Kimya</div></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-indigo-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Matematik</div></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-2 border border-white/10 text-white/30">11:00</td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-yellow-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Fizik</div></td>
                                            <td class="py-1 px-1 border border-white/10"></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-emerald-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Türkçe</div></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-indigo-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Matematik</div></td>
                                            <td class="py-1 px-1 border border-white/10"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 px-2 border border-white/10 text-white/30">14:00</td>
                                            <td class="py-1 px-1 border border-white/10"></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-purple-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Kimya</div></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-yellow-600/70 rounded-lg px-2 py-1.5 text-center font-semibold">Fizik</div></td>
                                            <td class="py-1 px-1 border border-white/10"></td>
                                            <td class="py-1 px-1 border border-white/10"><div class="bg-emerald-500/90 border border-emerald-400/60 rounded-lg px-2 py-1.5 text-center font-bold animate-pulse">Türkçe ✏️</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <div class="text-white/30 text-[10px]">15 görev • 5 gün</div>
                                <div class="h-7 bg-purple-600 rounded-lg flex items-center px-3 text-white text-[11px] font-bold gap-1.5 shadow-lg shadow-purple-900/40">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Öğrenciye Gönder
                                </div>
                            </div>
                        </div>

                        <!-- Panel 3 -->
                        <div id="dpanel-3" class="absolute inset-0 p-6 md:p-8 flex flex-col gap-4" style="opacity:0;transition:opacity 0.5s;pointer-events:none;">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-6 rounded-full bg-rose-500"></div>
                                <h3 class="text-white font-extrabold">Gelişim Takip Paneli</h3>
                                <span class="ml-auto text-white/30 text-[10px] font-mono">Ali Yılmaz • Bu Hafta</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-indigo-900/50 border border-indigo-500/30 rounded-2xl p-4">
                                    <div class="text-indigo-300 text-[10px] uppercase font-black tracking-wider">TYT Net Ort.</div>
                                    <div class="text-3xl font-black text-white mt-1">74.5</div>
                                    <div class="flex items-center gap-1 mt-1"><svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"/></svg><span class="text-emerald-400 text-[10px] font-semibold">+3.2 bu hafta</span></div>
                                    <div class="flex items-end gap-0.5 h-10 mt-3">
                                        <div class="flex-1 bg-indigo-500/40 rounded-sm" style="height:35%"></div>
                                        <div class="flex-1 bg-indigo-500/55 rounded-sm" style="height:50%"></div>
                                        <div class="flex-1 bg-indigo-500/65 rounded-sm" style="height:43%"></div>
                                        <div class="flex-1 bg-indigo-500/75 rounded-sm" style="height:60%"></div>
                                        <div class="flex-1 bg-indigo-500/90 rounded-sm" style="height:70%"></div>
                                        <div class="flex-1 bg-indigo-400 rounded-sm animate-pulse" style="height:90%"></div>
                                    </div>
                                </div>
                                <div class="bg-yellow-900/30 border border-yellow-500/30 rounded-2xl p-4">
                                    <div class="text-yellow-300 text-[10px] uppercase font-black tracking-wider">Görev Tamamlama</div>
                                    <div class="text-3xl font-black text-white mt-1">18<span class="text-base text-white/30">/24</span></div>
                                    <div class="text-yellow-400 text-[10px] font-semibold mt-1">%75 Tamamlandı</div>
                                    <div class="w-full h-2 bg-white/10 rounded-full mt-3"><div class="h-2 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-full" style="width:75%"></div></div>
                                </div>
                                <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                                    <div class="text-white/40 text-[10px] uppercase font-black tracking-wider mb-3">Son Aktiviteler</div>
                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></div><span class="text-white text-[11px]">Limit konusu ✓</span></div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></div><span class="text-white text-[11px]">35 soru çözüldü</span></div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-yellow-400 flex-shrink-0 animate-pulse"></div><span class="text-white/70 text-[11px]">Deneme girildi</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-2 mt-auto">
                                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-center"><div class="text-white font-black text-sm">12</div><div class="text-white/30 text-[9px] mt-0.5">Konu</div></div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-center"><div class="text-white font-black text-sm">340</div><div class="text-white/30 text-[9px] mt-0.5">Soru</div></div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-center"><div class="text-white font-black text-sm">5</div><div class="text-white/30 text-[9px] mt-0.5">Deneme</div></div>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-2.5 text-center"><div class="text-emerald-400 font-black text-sm">↑</div><div class="text-white/30 text-[9px] mt-0.5">Trend</div></div>
                            </div>
                        </div>

                    </div><!-- /panels -->

                    <!-- Progress bar -->
                    <div class="h-0.5 bg-white/10"><div id="demo-prog" class="h-0.5 bg-indigo-400" style="width:0%;transition:none;"></div></div>

                </div><!-- /screen -->
            </div><!-- /container -->

        </section>

        {{-- Subscription Packages (Geçici olarak kaldırıldı) --}}
    </main>

    <!-- Footer Section -->
    <footer class="w-full border-t border-slate-200 bg-white py-12 mt-16 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 justify-between">
            <div class="space-y-3">
                <span class="text-lg font-black tracking-tight text-slate-900">
                    rehber<span class="text-indigo-600">koçum</span>
                </span>
                <p class="text-slate-500 max-w-xs leading-relaxed">
                    Eğitim koçluğu sürecini akıllı yazılım çözümleriyle kolaylaştırıp öğrencilerinizi başarıya taşıyoruz.
                </p>
            </div>
            
            <div class="space-y-3">
                <h4 class="text-slate-800 font-bold uppercase tracking-wider text-[10px]">Hızlı Bağlantılar</h4>
                <ul class="space-y-2 text-slate-500">
                    <li><a href="#nedir" class="hover:text-indigo-600 transition">Nedir?</a></li>
                    <li><a href="#neden-var" class="hover:text-indigo-600 transition">Neden RehberKoçum?</a></li>
                    <li><a href="#ozellikler" class="hover:text-indigo-600 transition">Özellikler</a></li>
                    <li><a href="#nasil-calisir" class="hover:text-indigo-600 transition">Nasıl Çalışır?</a></li>
                </ul>
            </div>

            <div class="space-y-3">
                <p>&copy; 2026 rehberkoçum. Tüm hakları saklıdır.</p>
                <p>Bulut tabanlı öğrenci takip platformu. Özel kullanım lisansı.</p>
            </div>
        </div>
    </footer>

<script>
(function() {
    var TOTAL = 4;
    var DURATION = 4500;
    var current = 0;
    var playing = false;
    var rafId = null;
    var startTime = null;

    var urls = [
        'rehberkoçum.com/koc/ogrenciler/yeni',
        'rehberkoçum.com/koc/ali-yilmaz/dersler',
        'rehberkoçum.com/koc/ali-yilmaz/program',
        'rehberkoçum.com/koc/ali-yilmaz/gelisim'
    ];

    var sidebarColors = [
        'rgba(99,102,241,0.18)',
        'rgba(16,185,129,0.15)',
        'rgba(139,92,246,0.18)',
        'rgba(244,63,94,0.18)'
    ];

    var numColors = ['bg-indigo-600','bg-emerald-600','bg-purple-600','bg-rose-600'];
    var dotColors = ['bg-indigo-400','bg-emerald-400','bg-purple-400','bg-rose-400'];

    function showPanel(idx) {
        for (var i = 0; i < TOTAL; i++) {
            var p = document.getElementById('dpanel-' + i);
            var b = document.getElementById('dsb-' + i);
            if (!p || !b) continue;

            if (i === idx) {
                p.style.opacity = '1';
                p.style.pointerEvents = 'auto';
                b.style.background = sidebarColors[idx];
                b.style.opacity = '1';
                // Update number button style
                var numEl = b.querySelector('div');
                if (numEl) {
                    numEl.className = 'w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-black flex-shrink-0 shadow-lg ' + numColors[idx];
                }
                // Show right border indicator on desktop
                var bar = b.querySelector('.absolute');
                if (bar) bar.style.opacity = '1';
            } else {
                p.style.opacity = '0';
                p.style.pointerEvents = 'none';
                b.style.background = 'transparent';
                b.style.opacity = '0.45';
                var numEl2 = b.querySelector('div');
                if (numEl2) {
                    numEl2.className = 'w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-white/50 text-sm font-black flex-shrink-0';
                }
                var bar2 = b.querySelector('.absolute');
                if (bar2) bar2.style.opacity = '0';
            }
        }

        // URL bar
        var urlEl = document.getElementById('demo-url');
        if (urlEl) urlEl.textContent = urls[idx];

        // Dots
        for (var d = 0; d < TOTAL; d++) {
            var dot = document.getElementById('dd' + d);
            if (!dot) continue;
            if (d === idx) {
                dot.style.width = '24px';
                dot.className = 'h-1 rounded-full transition-all duration-400 ' + dotColors[idx];
            } else {
                dot.style.width = '8px';
                dot.className = 'h-1 rounded-full bg-white/20 transition-all duration-400';
            }
        }

        current = idx;
        resetProgress();
    }

    function resetProgress() {
        var bar = document.getElementById('demo-prog');
        if (!bar) return;
        bar.style.transition = 'none';
        bar.style.width = '0%';
    }

    function tick(ts) {
        if (!playing) return;
        if (!startTime) startTime = ts;
        var elapsed = ts - startTime;
        var pct = Math.min((elapsed / DURATION) * 100, 100);
        var bar = document.getElementById('demo-prog');
        if (bar) {
            bar.style.transition = 'none';
            bar.style.width = pct + '%';
        }
        if (pct >= 100) {
            var next = (current + 1) % TOTAL;
            showPanel(next);
            startTime = null;
        }
        rafId = requestAnimationFrame(tick);
    }

    function startPlay() {
        playing = true;
        startTime = null;
        rafId = requestAnimationFrame(tick);
        // Update icons
        var pi = document.getElementById('demo-pi');
        var pai = document.getElementById('demo-pai');
        var pim = document.getElementById('demo-pi-m');
        var paim = document.getElementById('demo-pai-m');
        var lbl = document.getElementById('demo-play-lbl');
        if (pi) pi.style.display = 'none';
        if (pai) pai.style.display = '';
        if (pim) pim.style.display = 'none';
        if (paim) paim.style.display = '';
        if (lbl) lbl.textContent = 'Duraklat';
    }

    function stopPlay() {
        playing = false;
        if (rafId) cancelAnimationFrame(rafId);
        rafId = null;
        startTime = null;
        resetProgress();
        var pi = document.getElementById('demo-pi');
        var pai = document.getElementById('demo-pai');
        var pim = document.getElementById('demo-pi-m');
        var paim = document.getElementById('demo-pai-m');
        var lbl = document.getElementById('demo-play-lbl');
        if (pi) pi.style.display = '';
        if (pai) pai.style.display = 'none';
        if (pim) pim.style.display = '';
        if (paim) paim.style.display = 'none';
        if (lbl) lbl.textContent = 'Otomatik Oynat';
    }

    window.demoGoTo = function(idx) {
        stopPlay();
        showPanel(idx);
    };

    window.demoTogglePlay = function() {
        if (playing) { stopPlay(); } else { startPlay(); }
    };

    // Init
    showPanel(0);
})();
</script>

</body>
</html>
