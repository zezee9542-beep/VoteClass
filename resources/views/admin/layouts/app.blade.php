<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Sekolah') - VoteClass</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
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

        /* Sidebar Badge at bottom */
        .sidebar-badge {
            background: linear-gradient(135deg, #e8f0e0 0%, #f0e8d0 100%);
            border-radius: 14px;
            border: 1px solid #d5dcb8;
            padding: 14px;
            margin: 12px;
            text-align: center;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5d1b0;
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8c9c72;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: transparent;
        }

        .sidebar-scroll:hover::-webkit-scrollbar-thumb {
            background: #c5d1b0;
        }

        .sidebar-scroll:hover::-webkit-scrollbar-thumb:hover {
            background: #8c9c72;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (min-width: 769px) {
            .sidebar.collapsed {
                width: 72px;
            }

            .sidebar.collapsed .sidebar-text,
            .sidebar.collapsed .sidebar-section-label,
            .sidebar.collapsed .sidebar-badge {
                display: none;
                opacity: 0;
            }

            .sidebar.collapsed .sidebar-nav-item {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            .sidebar.collapsed .logo-container {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            .main-content.expanded {
                margin-left: 72px;
            }

            .sidebar.collapsed #sidebarToggleIcon {
                transform: rotate(180deg);
            }
        }

        @yield('styles')
    </style>
</head>

<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- MAIN -->
    <div class="main-content" id="mainContent">

        <!-- Topbar -->
        <header class="topbar">
            <div class="flex items-center gap-4">
                <!-- Mobile toggle -->
                <button class="md:hidden text-[#405834]" onclick="toggleSidebar()">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                </button>
                <div>
                    <h1 class="text-[#2f3d20] font-bold text-[18px] leading-none">
                        @yield('page-title', 'Dashboard') <span class="text-[#405834]">— Panel Admin</span>
                    </h1>
                    <p class="text-[#aab2a3] text-[13px] font-medium mt-1.5">
                        @yield('page-subtitle', 'Kelola semua kelas dan wali kelas sekolah.')</p>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <!-- Avatar (clickable → profile popup) -->
                <div class="flex items-center gap-3 cursor-pointer pl-3 border-l border-[#e8e0c8] select-none" onclick="openProfilePopup()" title="Pengaturan Profil">
                    <div class="w-10 h-10 rounded-full bg-[#2f3d20] flex items-center justify-center overflow-hidden border-2 border-[#d5b263] hover:ring-2 hover:ring-[#d5b263]/50 transition-all">
                        <img id="topbarAvatarImg"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2f3d20&color=d5b263&bold=true' }}"
                            alt="Admin" class="w-full h-full object-cover">
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-[#2f3d20] font-bold text-[14px] leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[#aab2a3] text-[12px] font-medium mt-1">Admin</p>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aab2a3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden sm:block"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-[#fafaf8]">
            @yield('content')
        </main>
    </div>

    @include('partials.profile-popup', ['updateRoute' => route('admin.profile.update'), 'roleLabel' => 'Administrator'])

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
        function toggleSidebarDesktop() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        }
    </script>

    @include('partials.form-validation')
    @include('partials.success-animation')

    @yield('scripts')

</body>

</html>