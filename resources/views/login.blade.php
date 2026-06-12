<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - VoteClass</title>

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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdf9ef;
            background-image: radial-gradient(circle at top right, #fffdf8 0%, transparent 40%),
                radial-gradient(circle at bottom left, #fffdf8 0%, transparent 40%);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 4px rgba(140, 156, 114, 0.2);
            border-color: #8c9c72;
        }
        
        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .slide-up {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* 3D Button - Hero Siswa (Olive Green - Large) */
        .btn-hero-siswa {
            background-color: #8c9c72;
            color: #ffffff;
            box-shadow: 0 6px 0 #4e5a3c;
        }

        .btn-hero-siswa::before {
            background: linear-gradient(135deg, #9cb080 0%, #768a5c 100%);
        }

        .btn-hero-siswa:hover {
            transform: translateY(3px);
            box-shadow: 0 3px 0 #4e5a3c;
        }

        .btn-hero-siswa:active {
            transform: translateY(6px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #6a7a51;
        }

        /* 3D Button - Hero Admin (White - Large) */
        .btn-hero-admin {
            background-color: #ffffff;
            border: 2px solid #e2dcba;
            color: #405834;
            box-shadow: 0 6px 0 #c2bc9a;
        }

        .btn-hero-admin::before {
            background: linear-gradient(135deg, #ffffff 0%, #f7f5ea 100%);
        }

        .btn-hero-admin:hover {
            transform: translateY(3px);
            box-shadow: 0 3px 0 #c2bc9a;
            border-color: #c2bc9a;
        }

        .btn-hero-admin:active {
            transform: translateY(6px) !important;
            box-shadow: 0 0px 0 transparent !important;
            background-color: #f0ede0;
        }
    </style>
</head>

<body class="antialiased min-h-screen flex items-center justify-center p-0 m-0 relative overflow-hidden">
    
    <!-- Background decorative blur circles -->
    <div class="absolute top-[-20%] right-[-10%] w-[50%] h-[50%] bg-[#f7eed2] rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#eef1e6] rounded-full blur-[100px] -z-10"></div>

    <!-- Main Container -->
    <div class="w-full min-h-screen bg-white flex flex-col md:flex-row overflow-hidden fade-in">
        
        <!-- Left Side: Branding/Image -->
        <div class="hidden md:flex md:w-1/2 bg-[#fdf9ef] p-12 lg:p-16 flex-col relative overflow-hidden">
            
            <!-- decorative sparkles -->
            <svg class="absolute top-[15%] right-[20%] w-6 h-6 text-[#d5b263] opacity-80 animate-pulse" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
            <svg class="absolute top-[22%] right-[15%] w-4 h-4 text-[#d5b263] opacity-60 animate-pulse" style="animation-delay: 1s;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>
            <svg class="absolute top-[50%] left-[10%] w-5 h-5 text-[#d5b263] opacity-70 animate-pulse" style="animation-delay: 0.5s;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/>
            </svg>

            <div class="relative z-10 flex-shrink-0">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 mb-16 inline-flex">
                    <div class="relative w-7 h-7 border-[2.5px] border-[#405834] rounded-md flex justify-center items-center bg-white">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 13L9 17L19 5" stroke="#d5b263" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="font-bold text-[22px] tracking-tight"><span class="text-[#405834]">Vote</span><span class="text-[#d5b263]">Class</span></span>
                </a>

                <h1 class="font-sans font-bold text-[28px] text-[#405834] mb-1 slide-up tracking-tight" style="animation-delay: 0.2s">
                    Selamat Datang di
                </h1>
                <div class="font-sans font-extrabold text-[64px] leading-none mb-6 slide-up tracking-tight" style="animation-delay: 0.3s">
                    <span class="text-[#405834]">Vote</span><span class="text-[#d5b263]">Class</span>
                </div>
                
                <p class="text-[#5a5a5a] font-sans text-[15px] leading-relaxed max-w-[380px] slide-up font-medium" style="animation-delay: 0.4s">
                    Platform voting ketua kelas yang aman, adil, dan transparan untuk seluruh siswa.
                </p>
            </div>

            <!-- Image Vector with floating badge -->
            <div class="relative z-10 mt-auto pt-8 flex-1 flex items-end justify-center slide-up" style="animation-delay: 0.5s">
                <div class="relative w-full max-w-[450px]">
                    <img src="{{ asset('img/kotak.png') }}" alt="Kotak Suara" class="w-full object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500 relative z-10">
                    
                    <!-- Floating Badge -->
                    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 w-max bg-[#405834] text-white px-5 py-2.5 rounded-lg shadow-lg">
                        <!-- Badge content -->
                        <div class="text-center">
                            <div class="font-bold text-[11px] tracking-wide uppercase leading-tight text-white/90">Sistem Aman & Terpercaya</div>
                            <div class="font-bold text-[11px] tracking-wide uppercase leading-tight text-white/90">Untuk Pemilihan Yang Adil</div>
                        </div>
                        <!-- Tail -->
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-[#405834] rotate-45"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <!-- Right Side: Login Form -->
        <div class="w-full md:w-1/2 p-8 md:px-12 lg:px-20 xl:px-28 pt-12 md:pt-16 lg:pt-20 flex flex-col justify-start">
            
            <div class="mb-6 text-center slide-up" style="animation-delay: 0.2s">
                <h2 class="text-[#405834] font-extrabold text-[28px] mb-1 tracking-tight">Masuk ke Akun Anda</h2>
                <p class="text-[#6e7568] text-[15px] font-medium">Silakan masuk untuk melanjutkan</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4 slide-up" style="animation-delay: 0.3s">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-start gap-2.5 text-[14px] font-medium mb-1">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Email -->
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-[#405834] font-bold text-[13px]">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#8c9c72]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" class="input-field w-full pl-11 pr-4 py-3 bg-white border border-[#ebdcb9] rounded-xl text-[#405834] placeholder-[#aab2a3] font-medium outline-none text-[15px]" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-[#405834] font-bold text-[13px]">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#8c9c72]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" class="input-field w-full pl-11 pr-12 py-3 bg-white border border-[#ebdcb9] rounded-xl text-[#405834] placeholder-[#aab2a3] font-medium outline-none text-[15px]" required>
                        <!-- Toggle Password -->
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#aab2a3] hover:text-[#8c9c72] transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between mt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative w-4 h-4 flex items-center justify-center">
                            <input type="checkbox" class="peer appearance-none w-4 h-4 border-2 border-[#ebdcb9] rounded-[4px] checked:bg-[#8c9c72] checked:border-[#8c9c72] transition-colors cursor-pointer">
                            <svg class="absolute w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span class="text-[#6e7568] text-[13px] font-medium group-hover:text-[#405834] transition-colors">Ingat saya</span>
                    </label>
                    <a href="#" class="text-[#8c9c72] text-[13px] font-bold hover:text-[#405834] transition-colors">Lupa kata sandi?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-3d btn-hero-siswa w-full mt-2 font-bold text-[15px] py-3.5 rounded-xl gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H8.25" />
                    </svg>
                    Masuk
                </button>
                
                <!-- Divider -->
                <div class="flex items-center my-1">
                    <div class="flex-grow border-t border-[#ebdcb9]"></div>
                    <span class="px-4 text-[#8c9c72] text-[12px] font-bold">atau</span>
                    <div class="flex-grow border-t border-[#ebdcb9]"></div>
                </div>

                <!-- Google Button -->
                <button type="button" class="btn-3d btn-hero-admin w-full mt-1 font-bold text-[14px] py-3.5 rounded-xl gap-3">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Masuk dengan Google
                </button>
            </form>
            
            <div class="mt-6 text-center text-[13px] text-[#6e7568] font-medium slide-up" style="animation-delay: 0.4s">
                Belum punya akun? <a href="/register" class="text-[#809564] hover:text-[#5b6e44] font-bold underline decoration-2 underline-offset-4">Daftar di sini.</a>
            </div>

        </div>

    </div>

    @include('partials.form-validation')
    @include('partials.success-animation')
</body>

</html>
