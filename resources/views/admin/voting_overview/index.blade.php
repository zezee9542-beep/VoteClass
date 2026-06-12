@extends('admin.layouts.app')

@section('title', 'Rekap Voting')
@section('page-title', 'Rekap Voting Semua Kelas')
@section('page-subtitle', 'Pantau progres dan hasil akhir pemilihan dari setiap kelas di sekolah.')

@section('content')

    <!-- Rekap Cepat -->
    @php
    $selesai = collect($overview)->where('status', 'selesai')->count();
    $berlangsung = collect($overview)->where('status', 'berlangsung')->count();
    $belum = collect($overview)->where('status', 'belum')->count();
    $total = count($overview);
    @endphp

    <!-- Rekap Cepat -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#edf5e6] flex items-center justify-center text-[#405834]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Voting Selesai</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $selesai }} <span class="text-[14px] font-bold text-[#6e7568]">/ {{ $total }} Kelas</span></p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#fdf9ef] flex items-center justify-center text-[#d5b263]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Sedang Berlangsung</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $berlangsung }} <span class="text-[14px] font-bold text-[#6e7568]">Kelas</span></p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#f5f5f5] flex items-center justify-center text-[#6e7568]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Belum Mulai</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $belum }} <span class="text-[14px] font-bold text-[#6e7568]">Kelas</span></p>
        </div>
    </div>

    <!-- Data Rekap Card -->
    <div class="bg-white rounded-2xl border border-[#e8e0c8] shadow-sm overflow-hidden mb-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-5 border-b border-[#f5f5f5]">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#aab2a3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" placeholder="Cari kelas..." class="w-full pl-10 pr-4 py-2 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[14px] text-[#405834] placeholder-[#aab2a3] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <select class="py-2 pl-3 pr-8 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-bold text-[#6e7568] focus:outline-none focus:border-[#8c9c72]">
                    <option>Semua Tingkat</option>
                    <option>Kelas 9</option>
                    <option>Kelas 10</option>
                    <option>Kelas 11</option>
                </select>
                <select class="py-2 pl-3 pr-8 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-bold text-[#6e7568] focus:outline-none focus:border-[#8c9c72]">
                    <option>Semua Status</option>
                    <option>Selesai</option>
                    <option>Berlangsung</option>
                    <option>Belum Mulai</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fafaf7] border-b border-[#e8e0c8]">
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Wali Kelas</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Status Voting</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Partisipasi Suara</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Pemenang Sementara/Akhir</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f5f5f5]">
                    
                    @foreach($overview as $row)
                    <tr class="hover:bg-[#fdf9ef] transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-[14px] font-bold text-[#1f2937]">{{ $row['kelas'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-[#6e7568] font-medium">{{ $row['wali'] }}</td>
                        <td class="px-6 py-4">
                            @if($row['status'] === 'berlangsung')
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#d5b263] bg-[#fdf9ef] px-2.5 py-1 rounded-md border border-[#f5e6c3]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#d5b263] animate-pulse"></span>
                                    Berlangsung
                                </span>
                            @elseif($row['status'] === 'selesai')
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#405834] bg-[#edf5e6] px-2.5 py-1 rounded-md border border-[#d6e8c3]">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#6e7568] bg-[#f5f5f5] px-2.5 py-1 rounded-md border border-[#e8e0c8]">
                                    Belum Mulai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $pct = $row['total'] > 0 ? round(($row['suara'] / $row['total']) * 100) : 0;
                            @endphp
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between text-[11px] font-bold">
                                    <span class="{{ $pct == 100 ? 'text-[#405834]' : 'text-[#8c9c72]' }}">{{ $pct }}%</span>
                                    <span class="text-[#aab2a3]">{{ $row['suara'] }}/{{ $row['total'] }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-[#f0ede4] rounded-full overflow-hidden">
                                    <div class="h-full {{ $pct == 100 ? 'bg-[#405834]' : 'bg-[#d5b263]' }} rounded-full" style="width: {{ $pct }}%;"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[13px] font-bold text-[#1f2937]">{{ $row['pemenang'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="px-3 py-1.5 bg-white border border-[#e8e0c8] rounded-lg text-[12px] font-bold text-[#405834] group-hover:bg-[#edf5e6] group-hover:border-[#d6e8c3] transition-colors shadow-sm">
                                Lihat Laporan
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
