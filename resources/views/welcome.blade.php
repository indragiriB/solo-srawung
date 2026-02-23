<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoloSrawung - Berbagi Ilmu di Kota Solo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fade-in-down {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.3s ease-out; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .gradient-text { background: linear-gradient(to right, #6366f1, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-200">
<nav class="glass sticky top-0 z-50 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <span class="text-2xl font-bold tracking-tight">Solo<span class="text-amber-500">Srawung</span></span>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="#statistik" class="text-sm font-medium hover:text-indigo-400 transition">Statistik</a>
                <a href="#how-it-works" class="text-sm font-medium hover:text-indigo-400 transition">Cara Kerja</a>
                <a href="#lowongan" class="text-sm font-medium hover:text-indigo-400 transition">Lowongan</a>
                @auth
                    <div class="flex items-center space-x-4 border-l border-slate-700 pl-6">
                        <a href="/relawan" class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-full text-sm font-bold transition">Dashboard</a>
                        <form action="/relawan/logout" method="POST">@csrf <button type="submit" class="text-xs text-slate-400 hover:text-red-400 font-bold uppercase">Logout</button></form>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <button onclick="openLoginModal()" class="text-sm font-bold text-slate-300 hover:text-white transition">Login</button>
                        <a href="#daftar" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-indigo-500/20 transition">Daftar</a>
                    </div>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button onclick="toggleMobileMenu()" class="text-slate-300 hover:text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl" id="menuIcon"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden glass border-t border-slate-800 absolute w-full left-0 animate-fade-in-down">
        <div class="px-4 pt-4 pb-8 space-y-4">
            <a href="#statistik" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-300 hover:text-indigo-400 py-2">Statistik</a>
            <a href="#how-it-works" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-300 hover:text-indigo-400 py-2">Cara Kerja</a>
            <a href="#lowongan" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-300 hover:text-indigo-400 py-2">Lowongan</a>
            
            <div class="pt-4 border-t border-slate-800 space-y-4">
                @auth
                    <a href="/relawan" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-xl font-bold">Dashboard</a>
                    <form action="/relawan/logout" method="POST">
                        @csrf 
                        <button type="submit" class="w-full text-center text-red-400 font-bold uppercase text-xs tracking-widest pt-2">Logout</button>
                    </form>
                @else
                    <button onclick="openLoginModal(); toggleMobileMenu();" class="block w-full text-center text-slate-300 font-bold py-2">Login</button>
                    <a href="#daftar" onclick="toggleMobileMenu()" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-xl font-bold">Mulai Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

    @if(session('error') || session('success'))
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <div class="{{ session('error') ? 'bg-red-500/20 border border-red-500/50 text-red-200' : 'bg-emerald-500/20 border border-emerald-500/50 text-emerald-200' }} p-4 rounded-2xl text-center font-bold backdrop-blur-md">
            <i class="fas {{ session('error') ? 'fa-exclamation-circle' : 'fa-check-circle' }} mr-2"></i> {{ session('error') ?? session('success') }}
        </div>
    </div>
    @endif

    <section class="relative py-24 px-4 max-w-7xl mx-auto flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 z-10 text-center md:text-left">
            <div class="inline-block px-4 py-1.5 mb-6 bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 rounded-full text-xs font-bold uppercase tracking-widest">✨ Solo Digital Innovation 2026</div>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">Berbagi Ilmu, <br><span class="gradient-text">Membangun</span> Kota.</h1>
            <p class="text-slate-400 mb-8 text-lg leading-relaxed max-w-lg">Platform kolaborasi relawan pengajar untuk membantu sekolah-sekolah di Surakarta. Gabung sekarang dan jadilah bagian dari perubahan.</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center md:justify-start">
                <a href="#lowongan" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-bold shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 text-center">Eksplorasi Lowongan</a>
                <a href="/admin/login" class="glass text-slate-300 px-8 py-4 rounded-2xl font-bold hover:bg-slate-800 transition text-center flex items-center justify-center">
                    <i class="fas fa-school mr-2 text-amber-500"></i> Portal Sekolah
                </a>
            </div>
        </div>
     <div class="md:w-1/2 mt-16 md:mt-0 relative flex justify-center">
    <div class="absolute inset-0 bg-indigo-600 rounded-full blur-[120px] opacity-20 animate-pulse"></div>
    
    <img src="https://illustrations.popsy.co/white/studying.svg" 
         class="relative w-full max-w-md transform hover:-rotate-2 transition duration-700 drop-shadow-[0_0_30px_rgba(99,102,241,0.3)]"
         style="filter: invert(1) hue-rotate(180deg) brightness(1.5);">

    <div class="absolute -bottom-6 right-0 glass p-5 rounded-[2rem] border border-white/10 shadow-2xl animate-bounce">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-12 h-12  rounded-2xl rotate-12 absolute inset-0"></div>
                <div class="w-12 h-12 bg-slate-800 rounded-2xl border border-slate-700 relative flex items-center justify-center">
                    <i class="fas fa-heart text-amber-500"></i>
                </div>
            </div>
            <div>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Kontribusi</p>
                <p class="text-sm font-extrabold text-white">+500 Relawan</p>
            </div>
        </div>
    </div>
</div>
    </section>

    <section id="statistik" class="py-20 bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="text-4xl font-extrabold text-white mb-2">{{ \App\Models\Requirement::count() }}</div>
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-widest">Lowongan Aktif</div>
                </div>
                <div class="glass p-8 rounded-3xl text-center border-amber-500/20">
                    <div class="text-4xl font-extrabold text-amber-500 mb-2">{{ \App\Models\User::where('role', 'volunteer')->count() }}</div>
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-widest">Relawan Hebat</div>
                </div>
                <div class="glass p-8 rounded-3xl text-center">
                    <div class="text-4xl font-extrabold text-white mb-2">{{ \App\Models\Assignment::where('status', 'approved')->count() }}</div>
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-widest">Sekolah Terbantu</div>
                </div>
                <div class="glass p-8 rounded-3xl text-center border-indigo-500/20">
                    <div class="text-4xl font-extrabold text-indigo-400 mb-2">{{ \App\Models\Attendance::count() }}</div>
                    <div class="text-slate-500 text-xs font-bold uppercase tracking-widest">Jam Pengabdian</div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-24 px-4 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Langkah Pengabdian</h2>
            <div class="w-20 h-1.5 bg-indigo-600 mx-auto rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-12">
            <div class="relative text-center">
                <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-slate-700">
                    <i class="fas fa-user-plus text-2xl text-indigo-400"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">1. Registrasi Akun</h4>
                <p class="text-slate-400 text-sm leading-relaxed">Daftar sebagai relawan dengan data diri lengkap dan unggah CV terbaikmu.</p>
            </div>
            <div class="relative text-center">
                <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-slate-700">
                    <i class="fas fa-search-location text-2xl text-amber-400"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">2. Pilih Lowongan</h4>
                <p class="text-slate-400 text-sm leading-relaxed">Cari sekolah yang sesuai dengan mata pelajaran dan jadwal luangmu.</p>
            </div>
            <div class="relative text-center">
                <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-slate-700">
                    <i class="fas fa-chalkboard-teacher text-2xl text-emerald-400"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">3. Mulai Mengajar</h4>
                <p class="text-slate-400 text-sm leading-relaxed">Lakukan presensi kamera di lokasi sekolah dan dapatkan sertifikat pengabdian.</p>
            </div>
        </div>
    </section>

    <section id="lowongan" class="py-24 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Peluang Mengajar</h2>
                    <p class="text-slate-500 text-sm">Update terbaru: {{ date('d F Y') }}</p>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($lowongans as $job)
                <div id="lowongan-{{ $job->id }}" class="glass p-8 rounded-[2.5rem] hover:border-indigo-500/50 transition-all group overflow-hidden relative">
                    <div class="flex justify-between items-start mb-6">
                        <span class="bg-indigo-500/10 text-indigo-400 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest border border-indigo-500/20">{{ $job->subject }}</span>
                        @if($job->google_maps_url)
                            <a href="{{ $job->google_maps_url }}" target="_blank" class="text-slate-500 hover:text-red-400 transition">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </a>
                        @endif
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-2 group-hover:text-indigo-400 transition">{{ $job->school_name }}</h3>
                    <p class="text-slate-400 text-sm mb-6 line-clamp-3 leading-relaxed">{{ strip_tags($job->description) }}</p>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-slate-800">
                        <div>
                            <span class="block text-[10px] text-slate-500 uppercase font-bold">Beban Kerja</span>
                            <span class="text-indigo-400 font-extrabold">{{ $job->needed_hours }} Jam / Minggu</span>
                        </div>

                        @auth
                            @php
                                $applied = \App\Models\Assignment::where('volunteer_id', auth()->id())->where('requirement_id', $job->id)->exists();
                            @endphp
                            @if($applied)
                                <button disabled class="bg-slate-800 text-slate-500 px-6 py-2 rounded-xl text-xs font-bold flex items-center cursor-not-allowed">
                                    <i class="fas fa-check-double mr-2"></i> Terkirim
                                </button>
                            @else
                                <button onclick="openApplyModal('{{ $job->id }}', '{{ $job->school_name }}')" 
                                        class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-500/20">
                                    Lamar
                                </button>
                            @endif
                        @else
                            <button onclick="openLoginModal()" class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-2 rounded-xl text-sm font-bold transition">Lamar</button>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-32 border-t border-slate-900 bg-gradient-to-b from-slate-950 to-[#0f172a] relative overflow-hidden">
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-indigo-600/5 rounded-full blur-[120px]"></div>

    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-12 gap-16 items-start">
            
            <div class="lg:col-span-5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Live Activity
                </div>
                
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-8 tracking-tighter text-white">
                    Jejak <span class="text-amber-500 italic">Kebaikan.</span>
                </h2>
                
                <p class="text-slate-400 mb-10 leading-relaxed text-lg">
                    Aktivitas terbaru relawan di lapangan secara real-time.
                </p>

                <div class="relative space-y-6 before:absolute before:left-[19px] before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-800">
                    @forelse(\App\Models\Attendance::with('requirement')->latest()->take(3)->get() as $att)
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-1 w-10 h-10 rounded-full border border-slate-700 bg-slate-900 flex items-center justify-center z-10 group-hover:border-indigo-500 transition">
                            <i class="fas fa-paper-plane text-[10px] text-indigo-400"></i>
                        </div>
                        <div class="glass p-5 rounded-2xl border border-white/5 hover:bg-white/5 transition">
                            <div class="flex flex-wrap justify-between items-center gap-2 mb-1">
                                <span class="text-indigo-400 text-xs font-bold">{{ $att->requirement->school_name ?? 'Sekolah' }}</span>
                                <time class="text-[9px] text-slate-500 font-bold uppercase">{{ is_string($att->check_in) ? \Carbon\Carbon::parse($att->check_in)->diffForHumans() : $att->check_in->diffForHumans() }}</time>
                            </div>
                            <p class="text-slate-300 text-sm">Relawan telah melakukan presensi masuk.</p>
                        </div>
                    </div>
                    @empty
                    <div class="glass p-6 rounded-2xl text-center border-dashed border-slate-700">
                        <p class="text-slate-500 text-sm italic">Belum ada aktivitas.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="grid sm:grid-cols-2 gap-6 items-stretch">
                    <div class="glass p-8 rounded-[2.5rem] border-white/5 hover:bg-white/5 transition-all group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-600/10 rounded-full blur-2xl group-hover:bg-indigo-600/20 transition"></div>
                        <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-500/20">
                            <i class="fas fa-shield-alt text-2xl text-indigo-500"></i>
                        </div>
                        <h4 class="text-xl font-bold mb-3 text-white">Database Terintegrasi</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Terhubung langsung dengan data sekolah resmi di Surakarta melalui sistem terpusat.</p>
                    </div>

                    <div class="glass p-8 rounded-[2.5rem] border-white/5 hover:bg-white/5 transition-all group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition"></div>
                        <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6 border border-amber-500/20">
                            <i class="fas fa-camera-retro text-2xl text-amber-500"></i>
                        </div>
                        <h4 class="text-xl font-bold mb-3 text-white">Anti-Fraud System</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Presensi berbasis Face-Match dan Geotagging memastikan kehadiran relawan valid.</p>
                    </div>

                    <div class="glass p-8 rounded-[2.5rem] border-white/5 hover:bg-white/5 transition-all group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-600/10 rounded-full blur-2xl group-hover:bg-emerald-600/20 transition"></div>
                        <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center mb-6 border border-emerald-500/20">
                            <i class="fas fa-file-signature text-2xl text-emerald-500"></i>
                        </div>
                        <h4 class="text-xl font-bold mb-3 text-white">E-Sertifikat Instan</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Klaim sertifikat pengabdian otomatis setelah memenuhi jam mengajar yang ditentukan.</p>
                    </div>

                    <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-600/20 flex flex-col justify-center items-center text-center group cursor-pointer border border-indigo-400/50 h-full">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <i class="fas fa-rocket text-2xl text-white"></i>
                        </div>
                        <h4 class="text-white font-bold mb-2">Siap Beraksi?</h4>
                        <p class="text-indigo-100 text-xs mb-4">Mari buat perubahan bersama.</p>
                        <a href="#daftar" class="px-6 py-2 bg-white text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-indigo-50 transition">Gabung Sekarang</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

 <section id="daftar" class="py-32 bg-slate-950 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px] -z-0"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-amber-500/5 rounded-full blur-[100px] -z-0"></div>
    
    <div class="max-w-7xl mx-auto px-4 z-10 relative">
        @guest
            <div class="flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-5/12 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-widest mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        Join the Movement
                    </div>
                    <h2 class="text-5xl lg:text-7xl font-extrabold mb-8 leading-tight tracking-tighter">
                        Mulai <br>Ceritamu <span class="gradient-text">Disini.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed">
                        Hanya butuh 2 menit untuk bergabung. Berikan dampak nyata bagi pendidikan di Kota Solo dengan keahlian yang kamu miliki.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center group-hover:border-indigo-500/50 transition">
                                <i class="fas fa-certificate text-indigo-500"></i>
                            </div>
                            <span class="text-slate-300 font-medium">E-Sertifikat Resmi Pengabdian</span>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center group-hover:border-amber-500/50 transition">
                                <i class="fas fa-network-wired text-amber-500"></i>
                            </div>
                            <span class="text-slate-300 font-medium">Jejaring Relawan Se-Surakarta</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-7/12 w-full">
                    <div class="relative">
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-indigo-600/20 rounded-full blur-2xl"></div>
                        
                        <div class="glass p-8 lg:p-12 rounded-[3.5rem] w-full border border-white/5 relative z-10 shadow-2xl">
                           <form action="{{ route('register.custom') }}" method="POST" class="space-y-6">
    @csrf
    
    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500 text-red-200 p-4 rounded-xl text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="relative group">
        <i class="fas fa-user absolute left-5 top-5 text-slate-500 group-focus-within:text-indigo-500 transition"></i>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required 
            class="w-full pl-14 pr-6 py-5 bg-slate-900/50 border border-slate-800 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 text-white transition">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative group">
            <i class="fas fa-envelope absolute left-5 top-5 text-slate-500 group-focus-within:text-indigo-500 transition"></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required 
                class="w-full pl-14 pr-6 py-5 bg-slate-900/50 border border-slate-800 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 text-white transition">
        </div>
        <div class="relative group">
            <i class="fab fa-whatsapp absolute left-5 top-5 text-slate-500 group-focus-within:text-indigo-500 transition"></i>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="WhatsApp" required 
                class="w-full pl-14 pr-6 py-5 bg-slate-900/50 border border-slate-800 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 text-white transition">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative group">
            <i class="fas fa-lock absolute left-5 top-5 text-slate-500 group-focus-within:text-indigo-500 transition"></i>
            <input type="password" id="password" name="password" placeholder="Password (Min 8 Karakter)" 
                required minlength="8"
                class="w-full pl-14 pr-6 py-5 bg-slate-900/50 border border-slate-800 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 text-white transition">
            <p id="pass-hint" class="text-[10px] mt-2 ml-2 text-slate-500 italic">Minimal 8 karakter</p>
        </div>
        <div class="relative group">
            <i class="fas fa-shield-alt absolute left-5 top-5 text-slate-500 group-focus-within:text-indigo-500 transition"></i>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" 
                required minlength="8"
                class="w-full pl-14 pr-6 py-5 bg-slate-900/50 border border-slate-800 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 text-white transition">
        </div>
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-6 rounded-3xl font-extrabold text-xl shadow-xl shadow-indigo-600/30 transform active:scale-95 transition-all">
        Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
    </button>
</form>


                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="relative max-w-4xl mx-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-amber-500 rounded-[4rem] blur-[80px] opacity-10"></div>
                <div class="glass p-16 rounded-[4rem] border border-white/10 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <i class="fas fa-quote-right text-9xl"></i>
                    </div>
                    
                    <div class="w-24 h-24 bg-gradient-to-tr from-indigo-600 to-amber-500 rounded-3xl mx-auto mb-8 flex items-center justify-center text-white text-4xl shadow-2xl rotate-12">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    
                    <h2 class="text-5xl font-extrabold mb-6 tracking-tight">Senang Melihatmu Kembali, <br><span class="gradient-text">{{ explode(' ', auth()->user()->name)[0] }}!</span></h2>
                    <p class="text-slate-400 text-xl mb-12 max-w-2xl mx-auto leading-relaxed">Status relawanmu aktif. Mari lanjutkan kontribusi nyata untuk pendidikan anak-anak Surakarta hari ini.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                        <a href="/relawan" class="w-full sm:w-auto bg-white text-slate-950 px-12 py-5 rounded-2xl font-extrabold shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-th-large"></i> Buka Dashboard
                        </a>
                        <a href="#lowongan" class="w-full sm:w-auto glass px-12 py-5 rounded-2xl font-bold text-white hover:bg-slate-800 transition-all">
                            Lihat Lowongan Baru
                        </a>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</section>

    <footer class="bg-slate-950 border-t border-slate-900 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-2">
                <span class="text-3xl font-bold text-white mb-6 block">Solo<span class="text-amber-500">Srawung</span></span>
                <p class="text-slate-500 max-w-sm leading-relaxed mb-6">Inovasi pelayanan publik digital Kota Surakarta untuk menjembatani semangat pengabdian masyarakat dengan kebutuhan tenaga pendidik di sekolah.</p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-indigo-600 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-indigo-600 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 glass rounded-full flex items-center justify-center hover:bg-indigo-600 transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div>
                <h5 class="text-white font-bold mb-6">Tautan Cepat</h5>
                <ul class="space-y-4 text-sm text-slate-500 font-medium">
                    <li><a href="#statistik" class="hover:text-indigo-400 transition">Statistik Program</a></li>
                    <li><a href="#lowongan" class="hover:text-indigo-400 transition">Cari Sekolah</a></li>
                    <li><a href="/admin/login" class="hover:text-indigo-400 transition">Portal Sekolah</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-bold mb-6">Kontak</h5>
                <ul class="space-y-4 text-sm text-slate-500">
                    <li class="flex items-start"><i class="fas fa-map-marker-alt mt-1 mr-3 text-indigo-500"></i> Balai Kota Surakarta, <br>Jawa Tengah, Indonesia</li>
                    <li class="flex items-center"><i class="fas fa-envelope mr-3 text-indigo-500"></i> srawung@surakarta.go.id</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 text-center border-t border-slate-900 pt-10">
            <p class="text-slate-600 text-[10px] uppercase font-bold tracking-[0.3em]">© 2026 SoloSrawung Project • Krenova Surakarta</p>
        </div>
    </footer>

    <div id="loginModal" class="fixed inset-0 z-[100] hidden overflow-y-auto px-4">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-[#0f172a]/90 backdrop-blur-md" onclick="closeLoginModal()"></div>
            <div class="relative glass p-10 rounded-[3rem] max-w-md w-full border-t-4 border-indigo-500">
                <h3 class="text-3xl font-extrabold mb-8 text-center">Masuk</h3>
                <form action="{{ route('login.custom') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required class="w-full p-4 bg-slate-800/50 border border-slate-700 rounded-2xl text-white outline-none focus:ring-2 focus:ring-indigo-500">
                    <input type="password" name="password" placeholder="Password" required class="w-full p-4 bg-slate-800/50 border border-slate-700 rounded-2xl text-white outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-4 rounded-2xl font-bold transition shadow-lg shadow-indigo-600/20">Masuk Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <div id="applyModal" class="fixed inset-0 z-[100] hidden overflow-y-auto px-4">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-[#0f172a]/90 backdrop-blur-md" onclick="closeApplyModal()"></div>
            <div class="relative glass p-10 rounded-[3rem] max-w-md w-full border-b-8 border-indigo-600">
                <h3 class="text-2xl font-extrabold mb-2 text-center">Kirim CV</h3>
                <p id="modalSchoolName" class="text-indigo-400 font-bold mb-8 text-center italic"></p>
                <form id="applyForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="border-2 border-dashed border-slate-700 rounded-3xl p-8 text-center hover:bg-slate-800 transition relative">
                        <input type="file" name="file_cv" accept="application/pdf" required class="absolute inset-0 opacity-0 cursor-pointer">
                        <i class="fas fa-file-pdf text-4xl text-slate-600 mb-2"></i>
                        <p class="text-xs text-slate-500">Klik untuk upload (PDF Max 2MB)</p>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-bold shadow-lg shadow-indigo-600/20">Konfirmasi</button>
                    <button type="button" onclick="closeApplyModal()" class="w-full text-slate-500 font-bold text-sm">Batal</button>
                </form>
            </div>
        </div>
    </div>

    <script>



    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");
    const hint = document.getElementById("pass-hint");

    function validatePassword() {
        // Validasi Panjang
        if (password.value.length < 8) {
            hint.classList.replace('text-slate-500', 'text-red-400');
            hint.innerText = "Terlalu pendek! (Min 8)";
        } else {
            hint.classList.replace('text-red-400', 'text-emerald-400');
            hint.innerText = "Panjang password aman.";
        }

        // Validasi Kecocokan
        if (password.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Password tidak cocok!");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
    password.onkeyup = validatePassword;

        function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const icon = document.getElementById('menuIcon');
        
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times'); // Berubah jadi ikon 'X'
        } else {
            menu.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars'); // Balik jadi ikon 'Burger'
        }
    }
        function openLoginModal() { document.getElementById('loginModal').classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeLoginModal() { document.getElementById('loginModal').classList.add('hidden'); document.body.style.overflow = 'auto'; }
        function openApplyModal(jobId, schoolName) {
            document.getElementById('modalSchoolName').innerText = schoolName;
            document.getElementById('applyForm').action = "/apply-lowongan/" + jobId;
            document.getElementById('applyModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeApplyModal() { document.getElementById('applyModal').classList.add('hidden'); document.body.style.overflow = 'auto'; }
    </script>

</body>
</html>