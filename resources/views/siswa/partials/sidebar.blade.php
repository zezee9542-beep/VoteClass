<!-- ===================== SIDEBAR SISWA ===================== -->
<aside class="sidebar" id="sidebar">

    <!-- Toggle Button (Edge) -->
    <button onclick="toggleSidebarDesktop()" id="sidebarToggleBtn" class="hidden md:flex absolute top-6 -right-4 w-8 h-8 bg-white border border-[#e8e0c8] rounded-full items-center justify-center text-[#8c9c72] hover:text-[#405834] hover:bg-[#fdf9ef] transition-colors z-50 shadow-sm">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300" id="sidebarToggleIcon">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>

    <!-- Logo -->
    <div class="px-6 pt-6 pb-5 logo-container flex items-center">
        <a href="/siswa/dashboard" class="flex items-center gap-3 whitespace-nowrap">
            <div class="w-8 h-8 border-[2.5px] border-[#405834] rounded-md flex justify-center items-center bg-white flex-shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M5 13L9 17L19 5" stroke="#d5b263" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="font-extrabold text-[22px] tracking-tight leading-none sidebar-text">
                <span class="text-[#405834]">Vote</span><span class="text-[#d5b263]">Class</span>
            </span>
        </a>
    </div>

    <!-- Divider -->
    <div class="mx-5 mb-4 border-b border-[#e8e0c8]"></div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-2">

        <!-- Dashboard -->
        <a href="/siswa/dashboard" class="sidebar-nav-item mb-1 {{ request()->is('siswa/dashboard') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <div class="sidebar-section-label sidebar-text">Menu Utama</div>

        <!-- Lihat Kandidat (candidates table) -->
        <a href="/siswa/candidates" class="sidebar-nav-item mb-1 {{ request()->is('siswa/candidates') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="sidebar-text">Lihat Kandidat</span>
        </a>

        <!-- Berikan Suara (votes table) -->
        <a href="/siswa/vote" class="sidebar-nav-item mb-1 {{ request()->is('siswa/vote') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                <polyline points="9 11 12 14 22 4"/>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
            <span class="sidebar-text">Berikan Suara</span>
        </a>

        <!-- Hasil Voting (voting_results table) -->
        <a href="/siswa/results" class="sidebar-nav-item mb-1 {{ request()->is('siswa/results') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/>
                <line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <span class="sidebar-text">Hasil Voting</span>
        </a>

        <div class="sidebar-section-label sidebar-text">Akun Saya</div>

        <!-- Profil (users table) -->
        <a href="/siswa/profile" class="sidebar-nav-item mb-1 {{ request()->is('siswa/profile') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="sidebar-text">Profil Saya</span>
        </a>

    </nav>

    <!-- Sidebar Image -->
    <div class="px-3 pb-2 sidebar-text">
        <img src="{{ asset('img/side.png') }}" alt="Sidebar" class="w-full rounded-xl object-contain">
    </div>

    <!-- Logout -->
    <div class="px-3 py-3 mb-2">
        <a href="/logout" class="sidebar-nav-item text-red-500 hover:bg-red-50 hover:text-red-600">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            <span class="sidebar-text">Keluar</span>
        </a>
    </div>

</aside>
<!-- ===================== END SIDEBAR SISWA ===================== -->
