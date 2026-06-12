<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Siswa') - VoteClass</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        'brand-green': '#405834',
                        'brand-gold': '#d5b263',
                        'brand-bg': '#fdf9ef',
                        'brand-light': '#8c9c72',
                        'brand-dark': '#2f3d20',
                        'sidebar-bg': '#fdf9ef',
                        'sidebar-active': '#809564',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background-color: #fdf9ef;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            transition: transform 0.3s ease;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 10px;
            color: #5a5a5a;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .sidebar-nav-item:hover {
            background-color: #eee8d0;
            color: #405834;
        }

        .sidebar-nav-item.active {
            background-color: #809564;
            color: #ffffff;
            font-weight: 700;
        }

        .sidebar-nav-item.active svg {
            color: #ffffff;
        }

        .sidebar-nav-item svg {
            flex-shrink: 0;
            color: #8c9c72;
        }

        .sidebar-nav-item:hover svg {
            color: #405834;
        }

        .sidebar-section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #aab2a3;
            padding: 8px 16px 4px;
            margin-top: 8px;
        }

        .main-content {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e8e0c8;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .sidebar-badge {
            background: linear-gradient(135deg, #e8f0e0 0%, #f0e8d0 100%);
            border-radius: 14px;
            border: 1px solid #d5dcb8;
            padding: 14px;
            margin: 12px;
            text-align: center;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c5d1b0; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #8c9c72; }

        .sidebar-scroll::-webkit-scrollbar-thumb { background: transparent; }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb { background: #c5d1b0; }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb:hover { background: #8c9c72; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 45;
        }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        @media (min-width: 769px) {
            .sidebar.collapsed { width: 85px; }
            .sidebar.collapsed .sidebar-text,
            .sidebar.collapsed .sidebar-section-label,
            .sidebar.collapsed .sidebar-badge { display: none; opacity: 0; }
            .sidebar.collapsed .sidebar-nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
            .sidebar.collapsed .logo-container { justify-content: center; padding-left: 0; padding-right: 0; }
            .main-content.expanded { margin-left: 85px; }
            .sidebar.collapsed #sidebarToggleIcon { transform: rotate(180deg); }
        }

        @yield('styles')
    </style>
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar Siswa -->
@include('siswa.partials.sidebar')

<!-- ===================== MAIN ===================== -->
<div class="main-content" id="mainContent">

    <!-- Topbar -->
    <header class="topbar py-4 px-6 border-b border-[#e8e0c8] bg-white">
        <div class="flex items-center gap-4">
            <!-- Mobile toggle -->
            <button class="md:hidden text-[#405834]" onclick="toggleSidebar()">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div>
                <h1 class="text-[#2f3d20] font-bold text-[18px] leading-none">
                    Halo, <span class="text-[#405834]">{{ Auth::user()->name }}</span> 👋
                </h1>
                <p class="text-[#aab2a3] text-[13px] font-medium mt-1.5">Berikan suaramu dan ikuti pemilihan ketua kelas.</p>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <!-- Notification bell -->
            <button class="relative text-[#6e7568] hover:text-[#405834] transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-[#6e9f45] text-white text-[10px] font-bold rounded-full flex items-center justify-center border-[1.5px] border-white">1</span>
            </button>
            <!-- Avatar -->
            <div class="flex items-center gap-3 cursor-pointer pl-2 border-l border-[#e8e0c8]" onclick="openProfilePopup()" title="Pengaturan Profil">
                <div class="w-10 h-10 rounded-full bg-[#fdf9ef] flex items-center justify-center overflow-hidden border border-[#e8e0c8] hover:ring-2 hover:ring-[#d5b263]/50 transition-all">
                    <img id="topbarAvatarImg" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=dbeafe&color=1d4ed8&bold=true' }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <div class="hidden sm:block text-left">
                    <p class="text-[#2f3d20] font-bold text-[14px] leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[#aab2a3] text-[12px] font-medium mt-1">Siswa · Kelas {{ Auth::user()->class?->class_name }}</p>
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#aab2a3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden sm:block ml-1">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>
<!-- ===================== END MAIN ===================== -->

@include('partials.profile-popup', ['updateRoute' => route('siswa.profile.update'), 'roleLabel' => 'Siswa'])

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
    function toggleSidebarDesktop() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content');
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
    @include('partials.form-validation')
    @include('partials.success-animation')

    @yield('scripts')

</body>
</html>
