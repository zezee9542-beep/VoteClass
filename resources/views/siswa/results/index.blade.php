@extends('siswa.layouts.app')

@section('title', 'Hasil Voting Sementara')
@section('page-title', 'Hasil Voting')
@section('page-subtitle', 'Pantau hasil perolehan suara sementara Kelas ' . $class->class_name)

@section('content')

    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Hasil Pemilihan Ketua Kelas {{ $class->class_name }}</h2>
        <p class="text-[13px] font-medium text-[#6b7280]">Perolehan suara saat ini yang diperbarui secara langsung.</p>
    </div>

    <!-- Results Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Standings Cards (2 Cols) -->
        <div class="lg:col-span-2 space-y-4">
            
            @forelse($standings as $s)
            <div class="bg-white border border-[#e8e0c8] rounded-2xl p-5 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex items-start gap-4 relative z-10">
                    <!-- Rank badge -->
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-[16px] flex-shrink-0 bg-[#fdf9ef] border border-[#e8e0c8]">
                        @if($s['rank'] === 1)
                            🥇
                        @elseif($s['rank'] === 2)
                            🥈
                        @elseif($s['rank'] === 3)
                            🥉
                        @else
                            #{{ $s['rank'] }}
                        @endif
                    </div>
                    
                    <!-- Candidate Photo -->
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-[#d6e8c3] bg-white flex-shrink-0">
                        @if(isset($s['photo']) && $s['photo'])
                            <img src="{{ asset('storage/' . $s['photo']) }}" class="w-full h-full object-cover" alt="{{ $s['name'] }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($s['name']) }}&background=edf5e6&color=405834&bold=true" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- Candidate info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[15px] font-bold text-[#2f3d20]">{{ $s['name'] }}</h3>
                            <span class="text-[16px] font-extrabold text-[#405834]">{{ $s['pct'] }}%</span>
                        </div>
                        <p class="text-[11px] text-[#8c9c72] mt-0.5">Nomor Urut {{ $s['no'] }}</p>
                        
                        <!-- Progress bar -->
                        <div class="w-full h-3 bg-[#f0f4e8] rounded-full overflow-hidden mt-3">
                            <div class="h-full bg-[#6a874c] rounded-full" style="width: {{ $s['pct'] }}%;"></div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-2.5">
                            <span class="text-[11px] font-bold text-[#6e7568]">{{ $s['votes'] }} suara masuk</span>
                            <span class="text-[10px] text-[#aab2a3]">Terverifikasi</span>
                        </div>
                    </div>
                </div>
                <!-- Background Big Number -->
                <div class="absolute -right-4 -bottom-6 text-[90px] font-black text-[#fdf9ef] select-none pointer-events-none z-0">
                    {{ $s['no'] }}
                </div>
            </div>
            @empty
            <div class="bg-white border border-[#e8e0c8] rounded-2xl p-8 text-center text-[#9ca3af]">
                <p class="font-medium text-[15px]">Belum ada data kandidat aktif.</p>
            </div>
            @endforelse

        </div>

        <!-- Right Side: Election Progress Panel (1 Col) -->
        <div class="lg:col-span-1 bg-white border border-[#e8e0c8] rounded-2xl p-6 shadow-sm flex flex-col justify-between h-fit">
            <div>
                <h3 class="text-[#2f3d20] font-bold text-[15px] mb-4 pb-2 border-b border-[#fdf9ef]">Rangkuman Pemilihan</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[11px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Status</p>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#16a34a] bg-[#f0fdf4] border border-[#bbf7d0] px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 bg-[#16a34a] rounded-full animate-ping"></span>
                            Sedang Berlangsung
                        </span>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Tingkat Partisipasi</p>
                        <p class="text-[20px] font-bold text-[#2f3d20]">{{ $pct }}%</p>
                        <p class="text-[11px] text-[#6e7568]">{{ $sudahVoting }} dari {{ $totalSiswa }} siswa sudah memberikan suara</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Belum Memberikan Suara</p>
                        <p class="text-[20px] font-bold text-[#ef4444]">{{ $belumVoting }} Siswa</p>
                        <p class="text-[11px] text-[#6e7568]">Batas waktu memilih sedang berjalan</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-[#fdf9ef] text-center">
                <p class="text-[11px] text-[#aab2a3] leading-snug">Hasil akhir pemilihan ketua kelas akan diumumkan secara resmi setelah wali kelas ({{ $waliName }}) menutup pemungutan suara.</p>
            </div>
        </div>

    </div>

@endsection
