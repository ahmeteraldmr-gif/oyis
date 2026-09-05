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

        <!-- ===== NASIL ÇALIŞIR? - Animasyonlu Demo Bölümü ===== -->
        <section id="nasil-calisir" class="space-y-12">
            <!-- Section Header -->
            <div class="text-center space-y-4 max-w-3xl mx-auto">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                    🎬 Canlı Demo
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Nasıl Çalışır?</h2>
                <p class="text-slate-600 text-sm md:text-base">RehberKoçum'un koçluk sürecini nasıl kolaylaştırdığını 4 adımda keşfedin.</p>
            </div>

            <!-- Video Player Shell -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 bg-slate-900" style="max-width: 900px; margin: 0 auto;">

                <!-- Fake Browser Top Bar -->
                <div class="flex items-center gap-2 px-5 py-3 bg-slate-800 border-b border-slate-700">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                    <div class="flex-1 mx-4 bg-slate-700 rounded-md px-3 py-1 text-xs text-slate-400 font-mono">rehberkoçum.com/dashboard</div>
                </div>

                <!-- Demo Screen Area -->
                <div class="relative" style="min-height: 420px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">

                    <!-- Step Panels (shown/hidden via JS) -->

                    <!-- Step 1: Koç Öğrenci Ekler -->
                    <div id="demo-step-1" class="demo-panel absolute inset-0 p-6 md:p-10 flex flex-col gap-6 transition-all duration-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full">Adım 1</span>
                            <span class="text-white font-bold text-lg">Koç → Öğrenci Oluşturur</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Mock form card -->
                            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-5 space-y-3">
                                <div class="text-white text-sm font-semibold mb-3">✏️ Yeni Öğrenci Ekle</div>
                                <div class="space-y-2">
                                    <div class="h-8 bg-white/20 rounded-lg flex items-center px-3">
                                        <span class="text-white/60 text-xs">Ali Yılmaz</span>
                                    </div>
                                    <div class="h-8 bg-white/20 rounded-lg flex items-center px-3">
                                        <span class="text-white/60 text-xs">ali@gmail.com</span>
                                    </div>
                                    <div class="h-8 bg-white/20 rounded-lg flex items-center px-3">
                                        <span class="text-white/60 text-xs">••••••••</span>
                                    </div>
                                </div>
                                <div class="mt-3 h-9 bg-indigo-500 rounded-lg flex items-center justify-center text-white text-xs font-bold animate-pulse">
                                    ✓ Öğrenci Oluşturuldu!
                                </div>
                            </div>
                            <!-- Mock student card -->
                            <div class="space-y-3">
                                <div class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-2">Öğrenci Listesi</div>
                                <div class="bg-white/10 border border-white/20 rounded-xl p-3 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm">A</div>
                                    <div>
                                        <div class="text-white text-sm font-semibold">Ali Yılmaz</div>
                                        <div class="text-white/50 text-xs">ali@gmail.com</div>
                                    </div>
                                    <span class="ml-auto px-2 py-0.5 bg-emerald-500/30 text-emerald-300 text-xs rounded-full">Aktif</span>
                                </div>
                                <div class="bg-white/05 border border-white/10 rounded-xl p-3 flex items-center gap-3 opacity-50">
                                    <div class="w-9 h-9 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">Z</div>
                                    <div>
                                        <div class="text-white text-sm font-semibold">Zeynep Kara</div>
                                        <div class="text-white/50 text-xs">zeynep@gmail.com</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Ders Ataması -->
                    <div id="demo-step-2" class="demo-panel absolute inset-0 p-6 md:p-10 flex flex-col gap-4 hidden transition-all duration-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-emerald-600 text-white text-xs font-bold rounded-full">Adım 2</span>
                            <span class="text-white font-bold text-lg">Koç → Ders & Konu Atar</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <!-- Field cards -->
                            <div class="bg-emerald-500/20 border border-emerald-400/40 rounded-xl p-4 space-y-2">
                                <div class="text-emerald-300 text-xs font-bold uppercase">TYT</div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-emerald-400"></div>
                                        <span class="text-white text-xs">Matematik</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-emerald-400"></div>
                                        <span class="text-white text-xs">Türkçe</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-white/20"></div>
                                        <span class="text-white/50 text-xs">Fizik</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-500/20 border border-indigo-400/40 rounded-xl p-4 space-y-2">
                                <div class="text-indigo-300 text-xs font-bold uppercase">AYT</div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-indigo-400"></div>
                                        <span class="text-white text-xs">Kimya</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-sm bg-white/20"></div>
                                        <span class="text-white/50 text-xs">Biyoloji</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white/10 border border-white/20 rounded-xl p-4 col-span-2 md:col-span-1">
                                <div class="text-white/70 text-xs font-bold uppercase mb-2">📬 Atanan Konular</div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-white text-xs">Matematik - Limit</span>
                                        <span class="text-emerald-400 text-xs">✓</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-white text-xs">Türkçe - Paragraf</span>
                                        <span class="text-emerald-400 text-xs">✓</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-white text-xs">Kimya - Mol</span>
                                        <span class="text-yellow-400 text-xs animate-pulse">...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Haftalık Program -->
                    <div id="demo-step-3" class="demo-panel absolute inset-0 p-6 md:p-10 flex flex-col gap-4 hidden transition-all duration-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-purple-600 text-white text-xs font-bold rounded-full">Adım 3</span>
                            <span class="text-white font-bold text-lg">Koç → Haftalık Program Hazırlar</span>
                        </div>
                        <!-- Mini schedule grid -->
                        <div class="overflow-auto">
                            <table class="w-full text-xs text-white border-collapse">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-2 bg-white/10 border border-white/10 text-white/60 font-semibold text-left w-20">Saat</th>
                                        @foreach(['Pzt', 'Sal', 'Çar', 'Per', 'Cum'] as $day)
                                        <th class="py-2 px-2 bg-white/10 border border-white/10 text-white/70 font-semibold text-center">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-2 border border-white/10 text-white/50">09:00</td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-indigo-500/70 rounded px-2 py-1 text-center">Matematik</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-emerald-500/70 rounded px-2 py-1 text-center">Türkçe</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10"></td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-purple-500/70 rounded px-2 py-1 text-center">Kimya</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-indigo-500/70 rounded px-2 py-1 text-center">Matematik</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-2 border border-white/10 text-white/50">11:00</td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-yellow-500/70 rounded px-2 py-1 text-center">Fizik</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10"></td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-emerald-500/70 rounded px-2 py-1 text-center">Türkçe</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-indigo-500/70 rounded px-2 py-1 text-center">Matematik</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10"></td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-2 border border-white/10 text-white/50">14:00</td>
                                        <td class="py-1.5 px-1 border border-white/10"></td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-purple-500/70 rounded px-2 py-1 text-center">Kimya</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-yellow-500/70 rounded px-2 py-1 text-center">Fizik</div>
                                        </td>
                                        <td class="py-1.5 px-1 border border-white/10"></td>
                                        <td class="py-1.5 px-1 border border-white/10">
                                            <div class="bg-emerald-500/70 rounded px-2 py-1 text-center animate-pulse">Türkçe ✏️</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Step 4: Öğrenci Takibi & Analiz -->
                    <div id="demo-step-4" class="demo-panel absolute inset-0 p-6 md:p-10 flex flex-col gap-4 hidden transition-all duration-700">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-rose-600 text-white text-xs font-bold rounded-full">Adım 4</span>
                            <span class="text-white font-bold text-lg">Koç → Öğrenci Gelişimini Takip Eder</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Stat cards -->
                            <div class="bg-white/10 border border-white/20 rounded-2xl p-4 space-y-2">
                                <div class="text-white/60 text-xs uppercase font-bold">TYT Net Ortalaması</div>
                                <div class="text-4xl font-black text-white">74.5</div>
                                <div class="text-emerald-400 text-xs font-semibold">↑ +3.2 bu hafta</div>
                                <!-- Bar chart simulation -->
                                <div class="flex items-end gap-1 h-12 mt-2">
                                    <div class="flex-1 bg-indigo-500/50 rounded-sm" style="height: 40%"></div>
                                    <div class="flex-1 bg-indigo-500/60 rounded-sm" style="height: 55%"></div>
                                    <div class="flex-1 bg-indigo-500/70 rounded-sm" style="height: 48%"></div>
                                    <div class="flex-1 bg-indigo-500/80 rounded-sm" style="height: 65%"></div>
                                    <div class="flex-1 bg-indigo-500/90 rounded-sm" style="height: 72%"></div>
                                    <div class="flex-1 bg-indigo-400 rounded-sm animate-pulse" style="height: 88%"></div>
                                </div>
                            </div>
                            <div class="bg-white/10 border border-white/20 rounded-2xl p-4 space-y-2">
                                <div class="text-white/60 text-xs uppercase font-bold">Tamamlanan Görevler</div>
                                <div class="text-4xl font-black text-white">18<span class="text-xl text-white/40">/24</span></div>
                                <div class="text-yellow-400 text-xs font-semibold">%75 Tamamlandı</div>
                                <!-- Progress bar -->
                                <div class="w-full h-2 bg-white/20 rounded-full mt-2">
                                    <div class="h-2 bg-yellow-400 rounded-full" style="width: 75%; transition: width 1s ease;"></div>
                                </div>
                            </div>
                            <div class="bg-white/10 border border-white/20 rounded-2xl p-4 space-y-3">
                                <div class="text-white/60 text-xs uppercase font-bold">Son Aktiviteler</div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></div>
                                        <span class="text-white text-xs">Limit konusu tamamlandı</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></div>
                                        <span class="text-white text-xs">35 soru çözüldü</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-yellow-400 flex-shrink-0 animate-pulse"></div>
                                        <span class="text-white text-xs">Deneme sonucu girildi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress bar at bottom -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/10">
                        <div id="demo-progress-bar" class="h-1 bg-indigo-400 transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Player Controls -->
                <div class="bg-slate-800 px-6 py-4 flex flex-col gap-3">
                    <!-- Step indicators & step title -->
                    <div class="flex items-center gap-3 flex-wrap">
                        <button onclick="goToStep(1)" id="step-btn-1" class="step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-indigo-600 text-white">
                            <span>1</span> Öğrenci Ekle
                        </button>
                        <button onclick="goToStep(2)" id="step-btn-2" class="step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white/10 text-white/60 hover:bg-white/20">
                            <span>2</span> Ders Ata
                        </button>
                        <button onclick="goToStep(3)" id="step-btn-3" class="step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white/10 text-white/60 hover:bg-white/20">
                            <span>3</span> Program Oluştur
                        </button>
                        <button onclick="goToStep(4)" id="step-btn-4" class="step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white/10 text-white/60 hover:bg-white/20">
                            <span>4</span> Gelişimi İzle
                        </button>

                        <!-- Play/Pause button -->
                        <button id="play-pause-btn" onclick="togglePlayPause()" class="ml-auto flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-all">
                            <svg id="play-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg id="pause-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                            <span id="play-btn-text">Otomatik Oynat</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step descriptions below player -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mt-6">
                <div class="text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg mx-auto">👤</div>
                    <h4 class="text-sm font-bold text-slate-900">Öğrenci Ekle</h4>
                    <p class="text-xs text-slate-500">Saniyeler içinde öğrencini sisteme ekle, giriş bilgilerini oluştur.</p>
                </div>
                <div class="text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg mx-auto">📚</div>
                    <h4 class="text-sm font-bold text-slate-900">Ders Ata</h4>
                    <p class="text-xs text-slate-500">TYT & AYT derslerini ve konularını tek tıkla öğrenciye ata.</p>
                </div>
                <div class="text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-lg mx-auto">🗓️</div>
                    <h4 class="text-sm font-bold text-slate-900">Program Kur</h4>
                    <p class="text-xs text-slate-500">Saatli haftalık çalışma programı oluştur, öğrenci panelinde yayınla.</p>
                </div>
                <div class="text-center space-y-2">
                    <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg mx-auto">📊</div>
                    <h4 class="text-sm font-bold text-slate-900">Gelişimi Takip Et</h4>
                    <p class="text-xs text-slate-500">Net analizleri, görev tamamlama ve deneme gelişimini anlık izle.</p>
                </div>
            </div>
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
                    <li><a href="#paketler" class="hover:text-indigo-600 transition">Abonelik Paketleri</a></li>
                </ul>
            </div>

            <div class="space-y-3">
                <p>&copy; 2026 rehberkoçum. Tüm hakları saklıdır.</p>
                <p>Bulut tabanlı öğrenci takip platformu. Özel kullanım lisansı.</p>
            </div>
        </div>
    </footer>

<script>
    const TOTAL_STEPS = 4;
    const STEP_DURATION = 4000; // ms per step
    let currentStep = 1;
    let isPlaying = false;
    let autoTimer = null;
    let progressTimer = null;
    let progressStart = null;

    function goToStep(step) {
        // Hide all panels
        for (let i = 1; i <= TOTAL_STEPS; i++) {
            const panel = document.getElementById('demo-step-' + i);
            const btn = document.getElementById('step-btn-' + i);
            if (panel) panel.classList.add('hidden');
            if (btn) {
                btn.className = 'step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white/10 text-white/60 hover:bg-white/20';
            }
        }

        // Show active panel
        const activePanel = document.getElementById('demo-step-' + step);
        const activeBtn = document.getElementById('step-btn-' + step);
        if (activePanel) activePanel.classList.remove('hidden');

        // Color active button per step
        const colors = {
            1: 'bg-indigo-600 text-white',
            2: 'bg-emerald-600 text-white',
            3: 'bg-purple-600 text-white',
            4: 'bg-rose-600 text-white'
        };
        if (activeBtn) {
            activeBtn.className = 'step-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all ' + colors[step];
        }

        currentStep = step;
        resetProgressBar();

        // If playing, restart progress animation
        if (isPlaying) startProgressBar();
    }

    function resetProgressBar() {
        clearInterval(progressTimer);
        const bar = document.getElementById('demo-progress-bar');
        if (bar) bar.style.width = '0%';
        progressStart = null;
    }

    function startProgressBar() {
        resetProgressBar();
        progressStart = Date.now();
        progressTimer = setInterval(function() {
            const elapsed = Date.now() - progressStart;
            const pct = Math.min((elapsed / STEP_DURATION) * 100, 100);
            const bar = document.getElementById('demo-progress-bar');
            if (bar) bar.style.width = pct + '%';
            if (pct >= 100) {
                clearInterval(progressTimer);
                const next = currentStep < TOTAL_STEPS ? currentStep + 1 : 1;
                setTimeout(function() { goToStep(next); }, 300);
            }
        }, 50);
    }

    function togglePlayPause() {
        isPlaying = !isPlaying;

        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');
        const btnText = document.getElementById('play-btn-text');

        if (isPlaying) {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            btnText.textContent = 'Duraklat';
            startProgressBar();
        } else {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            btnText.textContent = 'Otomatik Oynat';
            resetProgressBar();
        }
    }

    // Init: show step 1
    document.addEventListener('DOMContentLoaded', function() {
        goToStep(1);
    });
</script>
</body>
</html>
