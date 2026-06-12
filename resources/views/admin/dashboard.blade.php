@extends('admin.layouts.app')

@section('title', 'Beranda Operator')
@section('page-title', 'Beranda')
@section('page-subtitle', 'Selamat datang! Ini adalah ringkasan keseluruhan sistem VoteClass.')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        <!-- Total Kelas -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-[12px] font-bold text-[#aab2a3] uppercase tracking-wide mb-2">Total Kelas</p>
                <p class="text-[36px] font-extrabold text-[#2f3d20] leading-none mb-1.5">{{ $totalClasses }}</p>
                <p class="text-[12px] font-medium text-[#6e7568]">Kelas aktif terdaftar</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-2xl bg-[#edf5e6] flex items-center justify-center flex-shrink-0">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#405834]" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
        </div>

        <!-- Total Wali Kelas -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-[12px] font-bold text-[#aab2a3] uppercase tracking-wide mb-2">Wali Kelas</p>
                <p class="text-[36px] font-extrabold text-[#2f3d20] leading-none mb-1.5">{{ $totalWaliKelas }}</p>
                <p class="text-[12px] font-medium text-[#6e7568]">Guru terdaftar</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-2xl bg-[#fdf9ef] flex items-center justify-center flex-shrink-0">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#d5b263]" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-[12px] font-bold text-[#aab2a3] uppercase tracking-wide mb-2">Total Siswa</p>
                <p class="text-[36px] font-extrabold text-[#2f3d20] leading-none mb-1.5">{{ $totalSiswa }}</p>
                <p class="text-[12px] font-medium text-[#6e7568]">Siswa terdaftar</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-2xl bg-[#edf5e6] flex items-center justify-center flex-shrink-0">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#405834]" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
        </div>

        <!-- Voting Aktif -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-[12px] font-bold text-[#aab2a3] uppercase tracking-wide mb-2">Voting Aktif</p>
                <p class="text-[36px] font-extrabold text-[#2f3d20] leading-none mb-1.5">{{ $votingAktif }}</p>
                <p class="text-[12px] font-medium text-[#6e7568]">Kelas sedang voting</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-2xl bg-[#fdf9ef] flex items-center justify-center flex-shrink-0">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#d5b263]" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 11 12 14 22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Middle Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

        <!-- Daftar Kelas & Status Voting -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#e8e0c8] shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#f5f5f5]">
                <h2 class="text-[#2f3d20] font-bold text-[16px]">Status Voting per Kelas</h2>
                <a href="/admin/classes" class="text-[13px] text-[#405834] font-semibold hover:underline flex items-center gap-1">
                    Lihat Semua
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
            <div class="divide-y divide-[#f5f5f5]">
                @foreach($classStatuses as $cls)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-[#fafaf7] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-[#edf5e6] flex items-center justify-center flex-shrink-0">
                            <span class="text-[12px] font-extrabold text-[#405834]">{{ substr($cls['name'], 0, 3) }}</span>
                        </div>
                        <div>
                            <p class="text-[14px] font-bold text-[#1f2937]">{{ $cls['name'] }}</p>
                            <p class="text-[12px] text-[#6e7568]">{{ $cls['wali'] }} · {{ $cls['siswa'] }} siswa</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-[13px] font-bold text-[#2f3d20]">{{ $cls['pct'] }}%</p>
                            <p class="text-[11px] text-[#9ca3af]">{{ $cls['suara'] }}/{{ $cls['siswa'] }} suara</p>
                        </div>
                        @if($cls['status'] === 'berlangsung')
                            <span class="text-[11px] font-bold text-[#d5b263] bg-[#fdf9ef] px-3 py-1 rounded-full border border-[#f5e6c3]">Berlangsung</span>
                        @elseif($cls['status'] === 'selesai')
                            <span class="text-[11px] font-bold text-[#405834] bg-[#edf5e6] px-3 py-1 rounded-full border border-[#d6e8c3]">Selesai</span>
                        @else
                            <span class="text-[11px] font-bold text-[#6e7568] bg-[#f5f5f5] px-3 py-1 rounded-full border border-[#e8e0c8]">Belum Mulai</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] shadow-sm p-5">
            <h2 class="text-[#2f3d20] font-bold text-[16px] mb-4">Aksi Cepat</h2>
            <div class="flex flex-col gap-3">
                <a href="/admin/classes" class="flex items-center gap-4 p-4 rounded-xl border border-[#f0ede4] hover:border-[#8c9c72] hover:bg-[#edf5e6] transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-[#edf5e6] flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#405834]" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </div>
                    <div>
                        <p class="text-[14px] font-bold text-[#1f2937]">Kelola Kelas</p>
                        <p class="text-[12px] text-[#6e7568]">Daftarkan & kelola kelas</p>
                    </div>
                </a>
                <a href="/admin/walikelas" class="flex items-center gap-4 p-4 rounded-xl border border-[#f0ede4] hover:border-[#d5b263] hover:bg-[#fdf9ef] transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-[#fdf9ef] flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#d5b263]" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    </div>
                    <div>
                        <p class="text-[14px] font-bold text-[#1f2937]">Kelola Wali Kelas</p>
                        <p class="text-[12px] text-[#6e7568]">Tugaskan guru ke kelas</p>
                    </div>
                </a>
                <a href="/admin/voting-overview" class="flex items-center gap-4 p-4 rounded-xl border border-[#f0ede4] hover:border-[#8c9c72] hover:bg-[#edf5e6] transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-[#edf5e6] flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-[#405834]" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <div>
                        <p class="text-[14px] font-bold text-[#1f2937]">Rekap Voting</p>
                        <p class="text-[12px] text-[#6e7568]">Lihat semua hasil voting</p>
                    </div>
                </a>
            </div>

            <!-- Info Box -->
            <div class="mt-4 p-4 rounded-xl bg-[#405834] text-white shadow-sm border border-[#2f3d20]">
                <p class="text-[12px] font-bold text-[#d5b263] mb-1">💡 Alur Sistem</p>
                <p class="text-[11px] text-[#e8e0c8] leading-relaxed">
                    1. Buat kelas → 2. Tugaskan Wali Kelas → 3. Wali Kelas daftarkan siswa & kandidat → 4. Voting berlangsung
                </p>
            </div>
        </div>

    </div>

    <!-- Wali Kelas Terbaru Ditambahkan -->
    <div class="bg-white rounded-2xl border border-[#e8e0c8] shadow-sm overflow-hidden mb-6">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#f5f5f5]">
            <h2 class="text-[#2f3d20] font-bold text-[16px]">Wali Kelas Terdaftar</h2>
            <a href="/admin/walikelas" class="text-[13px] text-[#405834] font-semibold hover:underline flex items-center gap-1">
                Kelola Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-0 divide-y sm:divide-y-0 sm:divide-x divide-[#f5f5f5]">
            @foreach($waliStatuses as $wk)
            <div class="flex items-center gap-4 p-5 hover:bg-[#fafaf7] transition-colors">
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 border border-[#e8e0c8]">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($wk['name']) }}&background=edf5e6&color=405834&bold=true" alt="{{ $wk['name'] }}" class="w-full h-full object-cover">
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] font-bold text-[#1f2937] truncate">{{ $wk['name'] }}</p>
                    <p class="text-[12px] text-[#6e7568]">Kelas {{ $wk['kelas'] ?? 'Belum diassign' }} · {{ $wk['siswa'] }} siswa</p>
                    @if($wk['status'] === 'berlangsung')
                        <span class="text-[10px] font-bold text-[#d5b263]">● Voting berlangsung</span>
                    @elseif($wk['status'] === 'selesai')
                        <span class="text-[10px] font-bold text-[#405834]">● Voting selesai</span>
                    @else
                        <span class="text-[10px] font-bold text-[#aab2a3]">● Belum mulai</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection
