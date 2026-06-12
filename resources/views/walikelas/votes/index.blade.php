@extends('walikelas.layouts.app')

@section('page-title', 'Data Suara')
@section('page-subtitle', 'Log aktivitas pengiriman suara pemilih')

@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Log Partisipasi Suara Kelas {{ $class->class_name }}</h2>
            <p class="text-[13px] font-medium text-[#6b7280]">Total {{ $sudahVoting }} suara terverifikasi masuk</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Search Bar -->
            <form action="{{ route('walikelas.votes') }}" method="GET" class="flex items-center gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa..." class="w-full sm:w-[200px] pl-9 pr-4 py-2 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent" onchange="this.form.submit()">
                </div>
            </form>

            <!-- Export Button -->
            <a href="{{ route('walikelas.votes.export') }}" class="bg-[#edf5e6] border border-[#d6e8c3] text-[#405834] text-[13px] font-bold px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#d6e8c3] transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Ekspor CSV
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2.5 text-[14px] font-medium">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">

        <!-- Total Pemilih (Blue pastel) -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#eff6ff] border-[#bfdbfe]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Total Pemilih</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $totalSiswa }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Kelas {{ $class->class_name }} terdaftar</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#3b82f6]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>

        <!-- Suara Masuk (Green pastel) -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#edf5e6] border-[#d6e8c3]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Suara Masuk</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $sudahVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $pct }}% Partisipasi</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#6a874c]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
        </div>

        <!-- Belum Memilih (Orange pastel) -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#fff3e3] border-[#fce0c2]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Belum Memilih</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $belumVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $totalSiswa > 0 ? round(($belumVoting / $totalSiswa) * 100) : 0 }}% dari total siswa</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#f59e0b]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
        </div>

    </div>

    <!-- Alert Box for Security and Anonymity -->
    <div class="bg-[#f8fbf5] border border-[#d6e8c3] rounded-xl p-4 mb-6 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-[#edf5e6] flex items-center justify-center text-[#405834] flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><circle cx="12" cy="11" r="3"/></svg>
        </div>
        <div>
            <h4 class="text-[#2f3d20] font-bold text-[14px] mb-0.5">Jaminan Anonimitas Pemilih</h4>
            <p class="text-[#6e7568] text-[12px] leading-relaxed">Log ini hanya mencatat <strong>siapa</strong> yang memilih dan <strong>kapan</strong> mereka memilih untuk memvalidasi daftar hadir pemilihan. Data <strong>siapa memilih siapa</strong> terenkripsi penuh dan tidak dapat dilihat oleh siapa pun, termasuk Wali Kelas.</p>
        </div>
    </div>

    <!-- Votes Log Table -->
    <div class="bg-white rounded-xl border border-[#f0f0f0] shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#f0f0f0] bg-[#fafbf8]">
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5 w-[80px]">ID Log</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Waktu Pemilihan</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Nama Siswa</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">NIS</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Alamat IP</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Status Log</th>
                </tr>
            </thead>
            <tbody>
                @forelse($votes as $v)
                <tr class="border-b border-[#f0f0f0] hover:bg-[#fafbf8] transition-colors last:border-0">
                    <td class="px-6 py-4 text-[13px] font-bold text-[#6b7280]">#VT-{{ str_pad($v->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 text-[13px] font-medium text-[#1f2937]">{{ $v->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($v->user ? $v->user->name : 'Tidak Diketahui') }}&background=edf5e6&color=405834&size=36&bold=true"
                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="Siswa">
                            <p class="text-[13px] font-bold text-[#1f2937] leading-tight">{{ $v->user ? $v->user->name : 'Tidak diketahui' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-[13px] font-medium text-[#4b5563]">{{ $v->user ? $v->user->nis_nip : '-' }}</td>
                    <td class="px-6 py-4 text-[12px] text-[#8c9c72] font-mono">{{ $v->ip_address ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-[#16a34a] bg-[#f0fdf4] border border-[#bbf7d0] px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-[#16a34a] rounded-full"></span>
                            Terverifikasi
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center gap-3 text-[#9ca3af]">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            <p class="font-medium text-[14px]">Belum ada suara yang masuk.</p>
                            <p class="text-[12px]">Log akan muncul ketika siswa mulai memberikan suara.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($votes->count() > 0)
        <!-- Footer -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-[#f0f0f0]">
            <p class="text-[12px] font-medium text-[#6b7280]">Menampilkan {{ $votes->count() }} dari {{ $sudahVoting }} log suara masuk</p>
            <div class="flex items-center gap-2">
                <span class="text-[12px] font-medium text-[#6b7280]">Total Partisipasi: <strong class="text-[#405834]">{{ $pct }}%</strong></span>
            </div>
        </div>
        @endif
    </div>

@endsection
