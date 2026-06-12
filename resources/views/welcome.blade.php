<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VoteClass - Sistem Voting Ketua Kelas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <!-- Fallback Tailwind CSS if Vite is not built -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#405834',
                        'brand-gold': '#d5b263',
                        'brand-bg': '#fdf9ef',
                        'brand-light-green': '#8c9c72',
                        'brand-dark-green': '#2f3d20',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            background-color: #fdf9ef;
            background-image: radial-gradient(circle at top right, #fffdf8 0%, transparent 40%),
                radial-gradient(circle at bottom left, #fffdf8 0%, transparent 40%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        /* 3D Button styles for smooth transition */
        .btn-3d {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            overflow: hidden;
            z-index: 1;
            transform: translateY(0);
            transition: transform 0.25s cubic-bezier(0.25, 0.8, 0.25, 1),
                box-shadow 0.25s cubic-bezier(0.25, 0.8, 0.25, 1),
                border-color 0.25s ease;
        }

        .btn-3d::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.25s ease;
        }

        .btn-3d:hover::before {
            opacity: 1;
        }

        /* 3D Button - Header Siswa (White) */
        .btn-header-siswa {
            background-color: #ffffff;
            border: 2px solid #e2dcba;
            color: #405834;
            box-shadow: 0 5px 0 #c2bc9a;
        }

        .btn-header-siswa::before {
            background: linear-gradient(135deg, #ffffff 0%, #f7f5ea 100%);
        }

        .btn-header-siswa:hover {
            transform: translateY(2.5px);
            box-shadow: 0 2.5px 0 #c2bc9a;
            border-color: #c2bc9a;
        }

        .btn-header-siswa:active {
            transform: translateY(5px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #f0ede0;
        }

        /* 3D Button - Header Admin (Olive) */
        .btn-header-admin {
            background-color: #8c9c72;
            color: #ffffff;
            box-shadow: 0 5px 0 #4e5a3c;
        }

        .btn-header-admin::before {
            background: linear-gradient(135deg, #9cb080 0%, #768a5c 100%);
        }

        .btn-header-admin:hover {
            transform: translateY(2.5px);
            box-shadow: 0 2.5px 0 #4e5a3c;
        }

        .btn-header-admin:active {
            transform: translateY(5px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #6a7a51;
        }

        /* 3D Button - Hero Siswa (Olive Green - Large) */
        .btn-hero-siswa {
            background-color: #8c9c72;
            color: #ffffff;
            box-shadow: 0 8px 0 #4e5a3c;
        }

        .btn-hero-siswa::before {
            background: linear-gradient(135deg, #9cb080 0%, #768a5c 100%);
        }

        .btn-hero-siswa:hover {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #4e5a3c;
        }

        .btn-hero-siswa:active {
            transform: translateY(8px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #6a7a51;
        }

        /* 3D Button - Hero Admin (White - Large) */
        .btn-hero-admin {
            background-color: #ffffff;
            border: 2px solid #e2dcba;
            color: #405834;
            box-shadow: 0 8px 0 #c2bc9a;
        }

        .btn-hero-admin::before {
            background: linear-gradient(135deg, #ffffff 0%, #f7f5ea 100%);
        }

        .btn-hero-admin:hover {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #c2bc9a;
            border-color: #c2bc9a;
        }

        .btn-hero-admin:active {
            transform: translateY(8px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #f0ede0;
        }

        /* Micro-animations */
        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }

        /* === Scroll Reveal Animations === */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.85);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes countPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Initial hidden state for scroll-reveal elements */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Page load animations */
        .anim-header {
            animation: slideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .anim-hero-text {
            animation: fadeInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
        }

        .anim-hero-image {
            animation: fadeInRight 1s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
        }

        .anim-hero-btn {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.7s both;
        }

        /* Stagger delays for cards */
        .stagger-1 { transition-delay: 0.1s !important; }
        .stagger-2 { transition-delay: 0.2s !important; }
        .stagger-3 { transition-delay: 0.3s !important; }
        .stagger-4 { transition-delay: 0.4s !important; }
        .stagger-5 { transition-delay: 0.5s !important; }
    </style>
</head>

<body id="top" class="font-sans text-gray-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Background decorative blur circles -->
    <div class="absolute top-[-20%] right-[-10%] w-[50%] h-[50%] bg-[#f7eed2] rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#eef1e6] rounded-full blur-[100px] -z-10"></div>

    <!-- Floating Navigation Header -->
    <header class="anim-header w-full px-6 pt-6 relative z-50 max-w-[1400px] mx-auto">
        <nav
            class="bg-white border border-[#eae3c8] rounded-2xl shadow-[0_8px_30px_rgba(64,88,52,0.04)] px-8 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2.5">
                <div class="relative w-7 h-7 border-[2.5px] border-[#8c9c72] rounded-md flex justify-center items-center bg-white">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13L9 17L19 5" stroke="#d5b263" stroke-width="3.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-bold text-[22px] tracking-tight"><span class="text-[#405834]">Vote</span><span
                        class="text-[#d5b263]">Class</span></span>
            </a>

            <!-- Links -->
            <div class="hidden md:flex items-center gap-10 text-[15px] font-semibold text-[#505050]">
                <div class="relative py-1">
                    <a href="#top" class="text-[#405834] hover:text-[#8c9c72] transition-colors">Beranda</a>
                    <span
                        class="absolute bottom-[-6px] left-0 w-full h-[3px] bg-[#d5b263] rounded-full"></span>
                </div>
                <a href="#fitur" class="hover:text-[#8c9c72] transition-colors">Fitur</a>
                <a href="#tentang" class="hover:text-[#8c9c72] transition-colors">Tentang</a>
                <a href="#cara-kerja" class="hover:text-[#8c9c72] transition-colors">Cara Kerja</a>
                <a href="#kontak" class="hover:text-[#8c9c72] transition-colors">Kontak</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-4">
                <a href="/login"
                    class="btn-3d btn-header-siswa flex items-center gap-2 px-8 py-2.5 rounded-xl font-bold text-[14px]">
                    Masuk
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </nav>
    </header>

    <main
        class="container mx-auto px-6 pt-16 lg:pt-20 pb-24 flex flex-col lg:flex-row items-center relative z-10 flex-1 max-w-[1400px]">
        <!-- Left Content -->
        <div class="w-full lg:w-[52%] flex flex-col items-start pr-0 lg:pr-12 lg:pl-10">
            <!-- Title -->
            <h1 class="anim-hero-text font-bold text-[84px] leading-[1] mb-6 tracking-tight">
                <span class="text-[#405834]">Vote</span><span class="text-[#d5b263]">Class</span>
            </h1>
            <h2 class="anim-hero-text text-[#405834] text-[38px] font-bold leading-[1.3] mb-6" style="animation-delay: 0.4s;">
                Sistem Voting Ketua Kelas<br>Mudah, Aman, dan Transparan
            </h2>

            <!-- Description -->
            <p class="anim-hero-text text-[#5a5a5a] text-[16px] mb-12 max-w-[500px] leading-[1.7] font-medium" style="animation-delay: 0.5s;">
                VoteClass membantu proses pemilihan ketua kelas menjadi lebih mudah, adil, dan terpercaya. Gunakan hak
                suaramu, tentukan pemimpin terbaik!
            </p>

            <!-- Big Action Buttons -->
            <div class="anim-hero-btn flex flex-col sm:flex-row gap-6 w-full max-w-[520px] mt-2">
                <!-- Action Button 1 (Login Siswa) -->
                <a href="/login"
                    class="btn-3d btn-hero-siswa flex-1 flex items-center gap-4 rounded-2xl p-4.5 group text-left">
                    <!-- Graduation Cap Icon -->
                    <div
                        class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0 shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 16.5v-3" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-[18px] leading-tight mb-1 text-white">Mulai Voting</div>
                        <div class="text-white/80 text-[13px] font-medium">Beri suaramu sekarang</div>
                    </div>
                </a>

                <!-- Action Button 2 (Login Admin) -->
                <a href="/login"
                    class="btn-3d btn-hero-admin flex-1 flex items-center gap-4 rounded-2xl p-4.5 group text-left">
                    <!-- Shield Icon -->
                    <div
                        class="w-12 h-12 bg-[#f0ede0] rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 text-[#405834]" fill="none" stroke="currentColor" stroke-width="2.2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-[18px] leading-tight mb-1 text-[#405834]">Kelola Pemilihan</div>
                        <div class="text-[#606060] text-[13px] font-medium">Masuk ke dashboard</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Right Content (Image) -->
        <div class="anim-hero-image w-full lg:w-[48%] mt-16 lg:mt-6 relative flex justify-center lg:justify-center">

            <!-- Background circles behind image -->
            <div class="absolute inset-0 flex items-center justify-center -z-10">
                <div class="w-[500px] h-[500px] bg-[#f2ebd4] rounded-full opacity-80" style="filter: blur(20px);"></div>
                <div class="absolute w-[400px] h-[400px] bg-[#ece2c2] rounded-full opacity-100"></div>
            </div>



            <!-- Sparkles -->
            <div class="absolute top-[15%] left-[-5%] animate-pulse" style="animation-duration: 3s;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" fill="#e8d595" />
                </svg>
            </div>
            <div class="absolute bottom-[20%] right-[-10%] animate-pulse"
                style="animation-duration: 2.5s; animation-delay: 1s;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" fill="#e8d595" />
                </svg>
            </div>
            <div class="absolute top-[50%] left-[-15%] animate-pulse"
                style="animation-duration: 4s; animation-delay: 2s;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" fill="#e8d595" />
                </svg>
            </div>

            <!-- Image Vector with enhanced shadow -->
            <div class="relative z-10 w-[110%] max-w-[550px] right-[-5%]"
                style="filter: drop-shadow(0 30px 30px rgba(64, 88, 52, 0.2)); transform: perspective(1000px) rotateY(-5deg) scale(1.02); transition: transform 0.5s ease-out;">
                <!-- Use image.png from public/img folder -->
                <img src="{{ asset('img/image.png') }}" alt="Voting Illustration" class="w-full h-auto object-contain">
            </div>

        </div>
    </main>

    <!-- Fitur Utama Section -->
    <section id="fitur" class="bg-white py-24 border-t border-[#f2ebd4]/60 relative z-20 w-full">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 flex flex-col items-center">

            <!-- Badge -->
            <div
                class="reveal inline-flex items-center gap-2.5 px-4.5 py-1.5 rounded-full bg-[#fdfcf7] border border-[#ebdcb9] mb-8 shadow-sm">
                <!-- Star Icon -->
                <svg class="w-3.5 h-3.5 text-[#d5b263]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.431 8.2 1.192-5.934 5.787 1.4 8.168L12 18.896l-7.334 3.858 1.4-8.168L.132 9.41l8.2-1.192L12 .587z" />
                </svg>
                <span class="text-[12px] font-extrabold tracking-widest text-[#405834] uppercase">Fitur Utama</span>
            </div>

            <!-- Heading -->
            <h2
                class="reveal text-[#405834] font-sans text-[36px] md:text-[44px] lg:text-[46px] font-extrabold leading-[1.2] text-center mb-6 max-w-[850px] tracking-tight">
                Semua yang Anda Butuhkan dalam Satu Platform
            </h2>

            <!-- Gold Divider Line -->
            <div class="w-16 h-[3.5px] bg-[#d5b263] rounded-full mb-16"></div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 w-full">

                <!-- Card 1: Login Siswa -->
                <div
                    class="reveal-scale stagger-1 bg-[#fffefe] border border-[#ebdcb9]/60 rounded-[28px] p-6 pb-10 flex flex-col items-center text-center shadow-[0_10px_35px_rgba(64,88,52,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_22px_45px_rgba(64,88,52,0.06)] hover:border-[#ebdcb9] group">
                    <!-- Icon Container -->
                    <div class="w-24 h-24 rounded-full bg-[#b5c0a4] flex items-center justify-center mb-8">
                        <!-- User Icon -->
                        <svg class="w-11 h-11 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4a4 4 0 110 8 4 4 0 010-8zm0 10c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-[#405834] font-sans text-[18px] font-extrabold mb-4 tracking-tight">Login Siswa</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium flex-1 mb-8">
                        Siswa dapat login dengan akun masing-masing untuk memberikan suara.
                    </p>
                    <!-- Small Gold Divider at Bottom -->
                    <div class="w-10 h-[3.5px] bg-[#d5b263] rounded-full mt-auto"></div>
                </div>

                <!-- Card 2: Login Admin -->
                <div
                    class="reveal-scale stagger-2 bg-[#fffefe] border border-[#ebdcb9]/60 rounded-[28px] p-6 pb-10 flex flex-col items-center text-center shadow-[0_10px_35px_rgba(64,88,52,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_22px_45px_rgba(64,88,52,0.06)] hover:border-[#ebdcb9] group">
                    <!-- Icon Container -->
                    <div class="w-24 h-24 rounded-full bg-[#b5c0a4] flex items-center justify-center mb-8 relative">
                        <!-- Shield + Gear Icon -->
                        <svg class="w-11 h-11 text-white transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 3.88l1.42 2.88 3.18.46-2.3 2.24.54 3.17L12 12.4l-2.84 1.49.54-3.17-2.3-2.24 3.18-.46L12 4.88z"/>
                        </svg>
                        <!-- Small gear badge -->
                        <div class="absolute -bottom-0.5 -right-0.5 w-8 h-8 bg-[#8c9c72] rounded-full border-[3px] border-white flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[#405834] font-sans text-[18px] font-extrabold mb-4 tracking-tight">Login Admin</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium flex-1 mb-8">
                        Admin login untuk mengelola sistem dan memastikan semua berjalan dengan baik.
                    </p>
                    <div class="w-10 h-[3.5px] bg-[#d5b263] rounded-full mt-auto"></div>
                </div>

                <!-- Card 3: Kelola Kandidat -->
                <div
                    class="reveal-scale stagger-3 bg-[#fffefe] border border-[#ebdcb9]/60 rounded-[28px] p-6 pb-10 flex flex-col items-center text-center shadow-[0_10px_35px_rgba(64,88,52,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_22px_45px_rgba(64,88,52,0.06)] hover:border-[#ebdcb9] group">
                    <!-- Icon Container -->
                    <div class="w-24 h-24 rounded-full bg-[#b5c0a4] flex items-center justify-center mb-8">
                        <!-- Group Users Icon -->
                        <svg class="w-12 h-12 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-[#405834] font-sans text-[18px] font-extrabold mb-4 tracking-tight">Kelola Kandidat
                    </h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium flex-1 mb-8">
                        Admin dapat menambah, mengedit, dan menghapus kandidat ketua kelas.
                    </p>
                    <div class="w-10 h-[3.5px] bg-[#d5b263] rounded-full mt-auto"></div>
                </div>

                <!-- Card 4: Kelola Kelas -->
                <div
                    class="reveal-scale stagger-4 bg-[#fffefe] border border-[#ebdcb9]/60 rounded-[28px] p-6 pb-10 flex flex-col items-center text-center shadow-[0_10px_35px_rgba(64,88,52,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_22px_45px_rgba(64,88,52,0.06)] hover:border-[#ebdcb9] group">
                    <!-- Icon Container -->
                    <div class="w-24 h-24 rounded-full bg-[#b5c0a4] flex items-center justify-center mb-8">
                        <!-- School Building Icon -->
                        <svg class="w-11 h-11 text-white transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                        </svg>
                    </div>
                    <h3 class="text-[#405834] font-sans text-[18px] font-extrabold mb-4 tracking-tight">Kelola Kelas
                    </h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium flex-1 mb-8">
                        Admin dapat mengelola data kelas dan siswa dengan mudah.
                    </p>
                    <div class="w-10 h-[3.5px] bg-[#d5b263] rounded-full mt-auto"></div>
                </div>

                <!-- Card 5: Voting & Hasil Voting -->
                <div
                    class="reveal-scale stagger-5 bg-[#fffefe] border border-[#ebdcb9]/60 rounded-[28px] p-6 pb-10 flex flex-col items-center text-center shadow-[0_10px_35px_rgba(64,88,52,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_22px_45px_rgba(64,88,52,0.06)] hover:border-[#ebdcb9] group">
                    <!-- Icon Container -->
                    <div class="w-24 h-24 rounded-full bg-[#b5c0a4] flex items-center justify-center mb-8 relative">
                        <!-- Ballot Box Icon -->
                        <svg class="w-11 h-11 text-white transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 13h-5v-1h5v1zm0-3h-5v1h5v-2zM3 14h5v7H3v-7zm0-6h5v5H3V8zm14-3V2H7v3H2v19h20V5h-5zm-6-1h4v2h-4V4zm8 17H5V7h14v14z"/>
                        </svg>
                        <!-- Small checkmark badge -->
                        <div class="absolute -bottom-0.5 -right-0.5 w-8 h-8 bg-[#8c9c72] rounded-full border-[3px] border-white flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-[#405834] font-sans text-[18px] font-extrabold mb-4 tracking-tight">Voting & Hasil
                        Voting</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium flex-1 mb-8">
                        Siswa melakukan voting dan hasil voting ditampilkan secara real-time dan transparan.
                    </p>
                    <div class="w-10 h-[3.5px] bg-[#d5b263] rounded-full mt-auto"></div>
                </div>

            </div>

        </div>
    </section>

    <!-- Kenapa VoteClass Section -->
    <section id="tentang" class="bg-[#fdf9ef] py-24 relative z-10 w-full overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 flex flex-col lg:flex-row items-center gap-16">
            
            <!-- Left Side: Text and Grid -->
            <div class="reveal-left w-full lg:w-[45%] flex flex-col items-start pr-0 lg:pr-4">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#f2ebd4] border border-[#eae3c8] mb-6 shadow-sm">
                    <!-- Leaf SVG -->
                    <svg class="w-4 h-4 text-[#405834]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66l.95-2.3c.48.17.96.3 1.34.3C12 20 22 13 22 4c0 0-4 1-5 4z" />
                    </svg>
                    <span class="text-[12px] font-extrabold tracking-widest text-[#405834] uppercase">Kenapa VoteClass?</span>
                </div>

                <!-- Heading -->
                <h2 class="text-[#405834] font-serif text-[32px] md:text-[38px] lg:text-[42px] font-bold leading-[1.2] mb-6 tracking-tight">
                    Pemilihan Adil,<br>Lingkungan Harmonis
                </h2>

                <!-- Description -->
                <p class="text-[#5a5a5a] text-[15px] leading-[1.7] font-medium max-w-[500px] mb-12">
                    VoteClass hadir untuk memastikan setiap suara siswa berarti. Wujudkan pemilihan yang demokratis dan bangun kepemimpinan terbaik di kelas Anda.
                </p>

                <!-- Features Grid 2x2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10 w-full">
                    
                    <!-- Item 1: Aman & Terpercaya -->
                    <div class="flex gap-4 items-start">
                        <!-- Icon Circle -->
                        <div class="w-14 h-14 rounded-full bg-[#e5ebd9] flex items-center justify-center flex-shrink-0">
                            <!-- Shield Check -->
                            <svg class="w-7 h-7 text-[#405834]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[#405834] font-bold text-[16px] mb-1">Aman & Terpercaya</h4>
                            <p class="text-[#6e7568] text-[13px] leading-[1.5] font-medium">
                                Sistem aman, data terjaga, hasil tidak dapat dimanipulasi.
                            </p>
                        </div>
                    </div>

                    <!-- Item 2: Mudah Digunakan -->
                    <div class="flex gap-4 items-start">
                        <!-- Icon Circle -->
                        <div class="w-14 h-14 rounded-full bg-[#e5ebd9] flex items-center justify-center flex-shrink-0">
                            <!-- Check Circle -->
                            <svg class="w-7 h-7 text-[#405834]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[#405834] font-bold text-[16px] mb-1">Mudah Digunakan</h4>
                            <p class="text-[#6e7568] text-[13px] leading-[1.5] font-medium">
                                Antarmuka sederhana dan intuitif untuk semua pengguna.
                            </p>
                        </div>
                    </div>

                    <!-- Item 3: Transparan -->
                    <div class="flex gap-4 items-start">
                        <!-- Icon Circle -->
                        <div class="w-14 h-14 rounded-full bg-[#e5ebd9] flex items-center justify-center flex-shrink-0">
                            <!-- Bar Chart -->
                            <svg class="w-7 h-7 text-[#405834]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[#405834] font-bold text-[16px] mb-1">Transparan</h4>
                            <p class="text-[#6e7568] text-[13px] leading-[1.5] font-medium">
                                Hasil voting real-time yang dapat dipantau kapan saja.
                            </p>
                        </div>
                    </div>

                    <!-- Item 4: Ramah Lingkungan -->
                    <div class="flex gap-4 items-start">
                        <!-- Icon Circle -->
                        <div class="w-14 h-14 rounded-full bg-[#e5ebd9] flex items-center justify-center flex-shrink-0">
                            <!-- Leaves -->
                            <svg class="w-7 h-7 text-[#405834]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66l.95-2.3c.48.17.96.3 1.34.3C12 20 22 13 22 4c0 0-4 1-5 4z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[#405834] font-bold text-[16px] mb-1">Ramah Lingkungan</h4>
                            <p class="text-[#6e7568] text-[13px] leading-[1.5] font-medium">
                                Mengurangi penggunaan kertas dengan sistem digital.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Right Side: Image -->
            <div class="reveal-right w-full lg:w-[55%] mt-16 lg:mt-0 relative flex justify-center lg:justify-end">
                <img src="{{ asset('img/kls.png') }}" alt="Ilustrasi Voting" class="w-full max-w-[800px] object-contain drop-shadow-2xl relative z-10 transform lg:scale-110 lg:translate-x-8 lg:translate-y-10" style="filter: drop-shadow(0 25px 25px rgba(64, 88, 52, 0.15));">
                
                <!-- Sparkles -->
                <div class="absolute top-[5%] left-[5%] animate-pulse z-20" style="animation-duration: 3s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" fill="#e8d595"/>
                    </svg>
                </div>
            </div>

        </div>
    </section>

    <!-- Cara Kerja Section -->
    <section id="cara-kerja" class="bg-white py-24 border-t border-[#f2ebd4]/60 relative z-20 w-full">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 flex flex-col items-center">
            
            <!-- Badge -->
            <div class="reveal inline-flex items-center gap-2.5 px-4.5 py-1.5 rounded-full bg-[#fdfcf7] border border-[#ebdcb9] mb-8 shadow-sm">
                <svg class="w-3.5 h-3.5 text-[#d5b263]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <span class="text-[12px] font-extrabold tracking-widest text-[#405834] uppercase">Alur Pemilihan</span>
            </div>

            <!-- Heading -->
            <h2 class="reveal text-[#405834] font-sans text-[36px] md:text-[44px] lg:text-[46px] font-extrabold leading-[1.2] text-center mb-6 max-w-[850px] tracking-tight">
                Bagaimana Cara Kerja VoteClass?
            </h2>

            <!-- Gold Divider Line -->
            <div class="w-16 h-[3.5px] bg-[#d5b263] rounded-full mb-16"></div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 w-full max-w-[1200px]">
                
                <!-- Step 1 -->
                <div class="reveal-scale stagger-1 flex flex-col items-center text-center relative">
                    <!-- Step Number Badge -->
                    <div class="w-16 h-16 rounded-full bg-[#fbf6e1] border-2 border-[#e8e0c8] flex items-center justify-center font-extrabold text-[#405834] text-[20px] mb-6 shadow-sm">
                        01
                    </div>
                    <h3 class="text-[#405834] font-bold text-[18px] mb-3">Persiapan Data</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium max-w-[240px]">
                        Admin mengonfigurasi data kelas, wali kelas, dan mengimpor data siswa.
                    </p>
                    <!-- Connector line -->
                    <div class="hidden md:block absolute top-8 left-[calc(50%+40px)] w-[calc(100%-80px)] h-[2px] border-t-2 border-dashed border-[#e8e0c8]"></div>
                </div>

                <!-- Step 2 -->
                <div class="reveal-scale stagger-2 flex flex-col items-center text-center relative">
                    <div class="w-16 h-16 rounded-full bg-[#fbf6e1] border-2 border-[#e8e0c8] flex items-center justify-center font-extrabold text-[#405834] text-[20px] mb-6 shadow-sm">
                        02
                    </div>
                    <h3 class="text-[#405834] font-bold text-[18px] mb-3">Daftarkan Kandidat</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium max-w-[240px]">
                        Wali Kelas mendaftarkan calon ketua kelas terbaik di kelasnya beserta visi misi.
                    </p>
                    <div class="hidden md:block absolute top-8 left-[calc(50%+40px)] w-[calc(100%-80px)] h-[2px] border-t-2 border-dashed border-[#e8e0c8]"></div>
                </div>

                <!-- Step 3 -->
                <div class="reveal-scale stagger-3 flex flex-col items-center text-center relative">
                    <div class="w-16 h-16 rounded-full bg-[#fbf6e1] border-2 border-[#e8e0c8] flex items-center justify-center font-extrabold text-[#405834] text-[20px] mb-6 shadow-sm">
                        03
                    </div>
                    <h3 class="text-[#405834] font-bold text-[18px] mb-3">Pemungutan Suara</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium max-w-[240px]">
                        Siswa masuk dan melakukan pemilihan secara langsung, bersih, dan rahasia.
                    </p>
                    <div class="hidden md:block absolute top-8 left-[calc(50%+40px)] w-[calc(100%-80px)] h-[2px] border-t-2 border-dashed border-[#e8e0c8]"></div>
                </div>

                <!-- Step 4 -->
                <div class="reveal-scale stagger-4 flex flex-col items-center text-center relative">
                    <div class="w-16 h-16 rounded-full bg-[#e5ebd9] border-2 border-[#c8d7b7] flex items-center justify-center font-extrabold text-[#405834] text-[20px] mb-6 shadow-sm">
                        04
                    </div>
                    <h3 class="text-[#405834] font-bold text-[18px] mb-3">Hasil Real-Time</h3>
                    <p class="text-[#6e7568] text-[13px] leading-[1.6] font-medium max-w-[240px]">
                        Sistem merekap suara secara otomatis dan hasil pemenang dapat langsung diketahui.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white pb-24 pt-12 relative z-20 w-full">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
            <div class="reveal-scale bg-[#fdfaf2] border border-[#f2ecd9] rounded-[2.5rem] py-8 px-6 lg:px-12 flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-4 shadow-sm">
                
                <!-- Stat 1: Siswa Aktif -->
                <div class="flex items-center gap-5 flex-1 justify-center lg:justify-start">
                    <!-- Icon: Graduation Cap + Person -->
                    <div class="w-[60px] h-[60px] relative flex-shrink-0 flex items-center justify-center">
                        <svg class="w-12 h-12 text-[#8c9c72]" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <!-- Graduation cap -->
                            <polygon points="32,8 6,22 32,36 58,22" opacity="0.9"/>
                            <!-- Cap brim hanging line + tassel -->
                            <rect x="52" y="22" width="3" height="14" rx="1.5" opacity="0.7"/>
                            <circle cx="53.5" cy="38" r="3" opacity="0.7"/>
                            <!-- People shapes -->
                            <circle cx="22" cy="42" r="5"/>
                            <path d="M10 58c0-6.6 5.4-12 12-12s12 5.4 12 12" opacity="0.85"/>
                            <circle cx="42" cy="42" r="5"/>
                            <path d="M30 58c0-6.6 5.4-12 12-12s12 5.4 12 12" opacity="0.85"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#394d2e] font-sans font-extrabold text-[38px] leading-none mb-1">10K+</span>
                        <span class="text-[#5a5a5a] font-sans text-[14px] font-bold tracking-wide">Siswa Aktif</span>
                    </div>
                </div>

                <!-- Divider 1 -->
                <div class="hidden lg:block w-[1.5px] h-16 bg-[#ebdcb9]/60"></div>

                <!-- Stat 2: Kelas Terdaftar -->
                <div class="flex items-center gap-5 flex-1 justify-center">
                    <!-- Icon: Detailed School Building -->
                    <div class="w-[60px] h-[60px] relative flex-shrink-0 flex items-center justify-center">
                        <svg class="w-12 h-12 text-[#8c9c72]" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <!-- Main building body -->
                            <rect x="10" y="28" width="44" height="30" rx="2"/>
                            <!-- Roof / triangle -->
                            <polygon points="32,6 4,30 60,30" opacity="0.85"/>
                            <!-- Flag pole -->
                            <rect x="31" y="6" width="2.5" height="10" rx="1"/>
                            <polygon points="33.5,6 33.5,14 40,10" opacity="0.7"/>
                            <!-- Windows row 1 -->
                            <rect x="16" y="34" width="8" height="8" rx="1.5" fill="white" opacity="0.5"/>
                            <rect x="28" y="34" width="8" height="8" rx="1.5" fill="white" opacity="0.5"/>
                            <rect x="40" y="34" width="8" height="8" rx="1.5" fill="white" opacity="0.5"/>
                            <!-- Door -->
                            <rect x="26" y="46" width="12" height="12" rx="2" fill="white" opacity="0.4"/>
                            <circle cx="35" cy="53" r="1.2" fill="white" opacity="0.7"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#394d2e] font-sans font-extrabold text-[38px] leading-none mb-1">250+</span>
                        <span class="text-[#5a5a5a] font-sans text-[14px] font-bold tracking-wide">Kelas Terdaftar</span>
                    </div>
                </div>

                <!-- Divider 2 -->
                <div class="hidden lg:block w-[1.5px] h-16 bg-[#ebdcb9]/60"></div>

                <!-- Stat 3: Pemilihan Selesai -->
                <div class="flex items-center gap-5 flex-1 justify-center">
                    <!-- Icon: Clipboard + Big Checkmark -->
                    <div class="w-[60px] h-[60px] relative flex-shrink-0 flex items-center justify-center">
                        <svg class="w-12 h-12 text-[#8c9c72]" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <!-- Clipboard board -->
                            <rect x="10" y="14" width="44" height="48" rx="4"/>
                            <!-- Clip at top -->
                            <rect x="24" y="8" width="16" height="12" rx="6" fill="white" opacity="0.5"/>
                            <rect x="28" y="6" width="8" height="8" rx="4" fill="white" opacity="0.3"/>
                            <!-- Lines (list items) -->
                            <rect x="18" y="28" width="18" height="3" rx="1.5" fill="white" opacity="0.4"/>
                            <rect x="18" y="36" width="14" height="3" rx="1.5" fill="white" opacity="0.4"/>
                            <rect x="18" y="44" width="16" height="3" rx="1.5" fill="white" opacity="0.4"/>
                            <!-- Big checkmark circle -->
                            <circle cx="45" cy="43" r="13" fill="#e8f0de"/>
                            <polyline points="38,43 43,49 53,37" fill="none" stroke="#8c9c72" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#394d2e] font-sans font-extrabold text-[38px] leading-none mb-1">1K+</span>
                        <span class="text-[#5a5a5a] font-sans text-[14px] font-bold tracking-wide">Pemilihan Selesai</span>
                    </div>
                </div>

                <!-- Divider 3 -->
                <div class="hidden lg:block w-[1.5px] h-16 bg-[#ebdcb9]/60"></div>

                <!-- Stat 4: Keamanan Sistem -->
                <div class="flex items-center gap-5 flex-1 justify-center lg:justify-end">
                    <!-- Icon: Shield with Lock -->
                    <div class="w-[60px] h-[60px] relative flex-shrink-0 flex items-center justify-center">
                        <svg class="w-12 h-12 text-[#8c9c72]" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <!-- Shield shape -->
                            <path d="M32 4 L8 16 L8 34 C8 48 20 58 32 62 C44 58 56 48 56 34 L56 16 Z" opacity="0.9"/>
                            <!-- Inner shield highlight -->
                            <path d="M32 12 L14 21 L14 34 C14 45 23 53 32 56 C41 53 50 45 50 34 L50 21 Z" fill="white" opacity="0.12"/>
                            <!-- Lock body -->
                            <rect x="24" y="34" width="16" height="13" rx="3" fill="white" opacity="0.75"/>
                            <!-- Lock shackle -->
                            <path d="M26 34 L26 29 C26 24.5 38 24.5 38 29 L38 34" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" opacity="0.75"/>
                            <!-- Keyhole -->
                            <circle cx="32" cy="39" r="2.5" fill="#8c9c72" opacity="0.9"/>
                            <rect x="30.5" y="40" width="3" height="4" rx="1" fill="#8c9c72" opacity="0.9"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[#394d2e] font-sans font-extrabold text-[38px] leading-none mb-1">99.9%</span>
                        <span class="text-[#5a5a5a] font-sans text-[14px] font-bold tracking-wide">Keamanan Sistem</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Banner Section -->
    <section class="bg-white pb-12 relative z-20 w-full">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
            <div class="reveal-scale bg-[#809564] rounded-[2.5rem] py-6 px-8 md:py-8 md:px-10 lg:px-12 relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-8 shadow-lg">
                
                <!-- Background Decorative Leaves & Sparkles -->
                <!-- Left Leaf -->
                <svg class="absolute top-0 left-0 h-[120%] text-white opacity-15 transform -translate-x-1/4 -translate-y-4 pointer-events-none" viewBox="0 0 100 200" fill="currentColor">
                    <path d="M10,200 C40,160 60,110 40,50 C10,90 -10,140 10,200 Z" />
                    <path d="M40,150 C70,110 80,60 50,10 C20,50 10,100 40,150 Z" />
                </svg>
                <!-- Right Leaf -->
                <svg class="absolute top-0 right-0 h-[120%] text-white opacity-15 transform translate-x-1/4 scale-x-[-1] -translate-y-4 pointer-events-none" viewBox="0 0 100 200" fill="currentColor">
                    <path d="M10,200 C40,160 60,110 40,50 C10,90 -10,140 10,200 Z" />
                    <path d="M40,150 C70,110 80,60 50,10 C20,50 10,100 40,150 Z" />
                </svg>
                <!-- Sparkle 1 -->
                <svg class="absolute top-10 left-[18%] w-6 h-6 text-[#e8d595] opacity-80" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
                </svg>
                <!-- Sparkle 2 -->
                <svg class="absolute bottom-10 left-[48%] w-8 h-8 text-[#e8d595] opacity-60" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
                </svg>
                <!-- Sparkle 3 -->
                <svg class="absolute top-12 right-[20%] w-5 h-5 text-[#e8d595] opacity-90" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
                </svg>

                <!-- Left Content: Icon + Text -->
                <div class="flex flex-col md:flex-row items-center md:items-center gap-5 lg:gap-8 relative z-10 text-center md:text-left">
                    <!-- Speaker Icon in Circle -->
                    <div class="w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full bg-[#fdfaf2] flex items-center justify-center flex-shrink-0 shadow-[0_10px_30px_rgba(0,0,0,0.1)] border-[3px] border-white/20">
                        <!-- User's speaker image -->
                        <img src="{{ asset('img/speaker.png') }}" alt="Speaker" class="w-12 h-12 lg:w-16 lg:h-16 object-contain">
                    </div>
                    
                    <!-- Text Box -->
                    <div class="flex flex-col max-w-[550px]">
                        <h2 class="text-white font-sans text-[24px] md:text-[28px] lg:text-[32px] font-extrabold leading-[1.2] mb-2 tracking-tight">
                            Gunakan hak suaramu sekarang!
                        </h2>
                        <p class="text-white/95 font-sans text-[14px] md:text-[15px] leading-relaxed font-medium">
                            Bersama VoteClass, wujudkan pemilihan yang jujur, adil, dan transparan.
                        </p>
                    </div>
                </div>

                <!-- Right Content: Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-4 relative z-10 w-full lg:w-auto mt-6 lg:mt-0 justify-center">
                    <!-- Button: Login Siswa -->
                    <a href="#" class="w-full sm:w-auto bg-[#fcf7e8] hover:bg-white text-[#405834] font-bold text-[16px] px-8 py-4 rounded-xl flex items-center justify-center gap-2.5 transition-all transform hover:-translate-y-1 shadow-[0_5px_15px_rgba(0,0,0,0.08)]">
                        Login Siswa
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <!-- Button: Login Admin -->
                    <a href="#" class="w-full sm:w-auto bg-black/20 hover:bg-black/30 text-white font-bold text-[16px] px-8 py-4 rounded-xl flex items-center justify-center gap-2.5 transition-all transform hover:-translate-y-1 backdrop-blur-sm border border-white/10">
                        Login Admin
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-[#fdf9ef] pt-12 pb-0 border-t border-[#ebdcb9]/40 mt-auto relative z-10 w-full">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8">
            
            <!-- Col 1: Logo & Desc -->
            <div class="lg:col-span-4 flex flex-col items-start pr-0 lg:pr-8">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-2.5 mb-4">
                    <div class="w-7 h-7 border-[2.5px] border-[#8c9c72] rounded-md flex items-center justify-center bg-white">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 13L9 17L19 5" stroke="#d5b263" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="text-[#405834] font-sans text-[22px] font-extrabold tracking-tight">Vote<span class="text-[#d5b263]">Class</span></span>
                </a>
                <p class="text-[#6e7568] font-sans text-[14px] leading-relaxed mb-6 font-medium max-w-[320px]">
                    Sistem voting ketua kelas yang mudah, aman, dan transparan untuk mewujudkan kepemimpinan terbaik.
                </p>
                <!-- Social Icons -->
                <div class="flex items-center gap-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-[#b5c0a4] text-white flex items-center justify-center hover:bg-[#8c9c72] transition-colors">
                        <!-- Instagram -->
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#b5c0a4] text-white flex items-center justify-center hover:bg-[#8c9c72] transition-colors">
                        <!-- Facebook -->
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#b5c0a4] text-white flex items-center justify-center hover:bg-[#8c9c72] transition-colors">
                        <!-- LinkedIn -->
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#b5c0a4] text-white flex items-center justify-center hover:bg-[#8c9c72] transition-colors">
                        <!-- YouTube -->
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Navigasi -->
            <div class="lg:col-span-2 flex flex-col">
                <h4 class="text-[#405834] font-bold text-[16px] mb-5">Navigasi</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#top" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Beranda</a></li>
                    <li><a href="#fitur" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Fitur</a></li>
                    <li><a href="#tentang" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Tentang</a></li>
                    <li><a href="#cara-kerja" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Cara Kerja</a></li>
                    <li><a href="#kontak" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Kontak</a></li>
                </ul>
            </div>

            <!-- Col 3: Fitur -->
            <div class="lg:col-span-3 flex flex-col">
                <h4 class="text-[#405834] font-bold text-[16px] mb-5">Fitur</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Login Siswa</a></li>
                    <li><a href="#" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Login Admin</a></li>
                    <li><a href="#" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Kelola Kandidat</a></li>
                    <li><a href="#" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Kelola Kelas</a></li>
                    <li><a href="#" class="text-[#6e7568] text-[14px] hover:text-[#405834] transition-colors font-medium">Voting & Hasil Voting</a></li>
                </ul>
            </div>

            <!-- Col 4: Kontak -->
            <div class="lg:col-span-3 flex flex-col">
                <h4 class="text-[#405834] font-bold text-[16px] mb-5">Kontak</h4>
                <ul class="flex flex-col gap-4">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#8c9c72]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <span class="text-[#6e7568] text-[14px] font-medium">info@voteclass.id</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#8c9c72]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        <span class="text-[#6e7568] text-[14px] font-medium">0812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#8c9c72]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <span class="text-[#6e7568] text-[14px] font-medium">Indonesia</span>
                    </li>
                </ul>
            </div>

        </div>
    </footer>

    <!-- Scroll Reveal Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for scroll reveal
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -80px 0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all reveal elements
            document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

</body>

</html>