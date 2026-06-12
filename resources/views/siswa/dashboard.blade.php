@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, Siswa!')

@section('content')

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-[#405834] to-[#6a874c] rounded-2xl p-6 mb-6 relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/3 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full" fill="none">
                <circle cx="150" cy="50" r="80" fill="white"/>
                <circle cx="50" cy="150" r="60" fill="white"/>
            </svg>
        </div>
        <p class="text-[#d5e8c0] text-[13px] font-bold mb-1 uppercase tracking-widest">VoteClass</p>
        <h2 class="text-white text-[22px] font-bold mb-2 leading-tight">Halo, {{ Auth::user()->name }}! Sudah siap memilih? 🗳️</h2>
        <p class="text-[#b8d9a0] text-[13px] font-medium mb-4 max-w-md">Pemilihan ketua kelas sedang berlangsung. Pastikan kamu sudah memberikan suaramu sebelum periode berakhir.</p>
        @if(!$votingStatus)
        <a href="{{ route('siswa.vote') }}" class="inline-flex items-center gap-2 bg-white text-[#405834] text-[13px] font-bold px-5 py-2.5 rounded-lg hover:bg-[#f0f9e8] transition-colors shadow-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            Berikan Suaraku Sekarang
        </a>
        @else
        <a href="{{ route('siswa.results') }}" class="inline-flex items-center gap-2 bg-[#d5b263] text-white text-[13px] font-bold px-5 py-2.5 rounded-lg hover:bg-[#c2a053] transition-colors shadow-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Lihat Hasil Sementara
        </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        
        <!-- Status Voting -->
        <div class="rounded-xl p-4 {{ $votingStatus ? 'bg-[#edf5e6] border-[#d6e8c3]' : 'bg-[#fffbf5] border-[#fce0c2]' }} border flex items-center gap-4">
            <div class="w-[42px] h-[42px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 {{ $votingStatus ? 'text-[#6a874c]' : 'text-[#f59e0b]' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <p class="text-[12px] font-bold text-[#4b5563] mb-0.5">Status Voting</p>
                <p class="text-[15px] font-bold {{ $votingStatus ? 'text-[#6a874c]' : 'text-[#f59e0b]' }}">
                    {{ $votingStatus ? 'Sudah Memilih' : 'Belum Memilih' }}
                </p>
            </div>
        </div>

        <!-- Kandidat Tersedia -->
        <div class="rounded-xl p-4 bg-[#fffbf5] border border-[#fce0c2] flex items-center gap-4">
            <div class="w-[42px] h-[42px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 text-[#f59e0b]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="text-[12px] font-bold text-[#4b5563] mb-0.5">Kandidat Tersedia</p>
                <p class="text-[20px] font-bold text-[#1f2937] leading-none">{{ $totalCandidates }}</p>
            </div>
        </div>

        <!-- Sisa Waktu / Status Pemilihan -->
        <div class="rounded-xl p-4 bg-[#fef2f2] border border-[#fecaca] flex items-center gap-4">
            <div class="w-[42px] h-[42px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 text-[#ef4444]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="text-[12px] font-bold text-[#4b5563] mb-0.5">Status Pemilihan</p>
                <p class="text-[15px] font-bold text-[#ef4444]">Sedang Berlangsung</p>
            </div>
        </div>

    </div>

    <!-- Kandidat Preview & Hasil Sementara -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- Daftar Kandidat -->
        <div class="lg:col-span-3 bg-white rounded-xl border border-[#f0f0f0] shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-[#1f2937] font-bold text-[16px]">Kandidat Kelas {{ $class->class_name }}</h2>
                <a href="{{ route('siswa.candidates') }}" class="text-[13px] text-[#6a874c] font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($candidates as $c)
                <div class="flex items-center gap-4 p-3 rounded-xl border border-[#f0f0f0] hover:border-[#d6e8c3] hover:bg-[#fafbf8] transition-all group">
                    @if($c->photo)
                        <img src="{{ asset('storage/' . $c->photo) }}" class="w-10 h-10 rounded-full flex-shrink-0 object-cover" alt="{{ $c->name }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($c->name) }}&background=edf5e6&color=405834&size=40&bold=true" class="w-10 h-10 rounded-full flex-shrink-0" alt="{{ $c->name }}">
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-bold text-[#1f2937] leading-tight">{{ $c->name }}</p>
                        <p class="text-[11px] text-[#6b7280] truncate">{{ $c->visi ?? 'Belum mengisi visi' }}</p>
                    </div>
                    @if(!$votingStatus)
                    <a href="{{ route('siswa.vote') }}" class="flex-shrink-0 text-[12px] font-bold text-[#6a874c] bg-[#edf5e6] hover:bg-[#6a874c] hover:text-white px-3 py-1.5 rounded-lg transition-all duration-200 opacity-0 group-hover:opacity-100">
                        Pilih
                    </a>
                    @endif
                </div>
                @empty
                <div class="py-6 text-center text-[#9ca3af] text-[13px]">
                    Belum ada kandidat aktif di kelas ini.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Hasil Sementara -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-[#f0f0f0] shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-[#1f2937] font-bold text-[16px]">Hasil Sementara</h2>
                <a href="{{ route('siswa.results') }}" class="text-[13px] text-[#6a874c] font-medium hover:underline">Lengkap</a>
            </div>
            <div class="space-y-4">
                @forelse($rankedStandings as $r)
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-bold">
                                @if($r['rank'] === 1)
                                    🥇
                                @elseif($r['rank'] === 2)
                                    🥈
                                @elseif($r['rank'] === 3)
                                    🥉
                                @else
                                    #{{ $r['rank'] }}
                                @endif
                            </span>
                            <p class="text-[13px] font-bold text-[#1f2937]">{{ $r['name'] }}</p>
                        </div>
                        <span class="text-[13px] font-bold text-[#6a874c]">{{ $r['pct'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-[#f0f4e8] rounded-full overflow-hidden">
                        <div class="h-full bg-[#6a874c] rounded-full transition-all duration-500" style="width: {{ $r['pct'] }}%;"></div>
                    </div>
                    <p class="text-[10px] text-[#9ca3af] mt-1">{{ $r['votes'] }} suara</p>
                </div>
                @empty
                <div class="py-6 text-center text-[#9ca3af] text-[13px]">
                    Belum ada suara masuk.
                </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection
