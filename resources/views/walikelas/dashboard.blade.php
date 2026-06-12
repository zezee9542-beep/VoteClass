@extends('walikelas.layouts.app')

@section('title', 'Beranda')
@section('page-title', 'Beranda')
@section('page-subtitle', 'Selamat datang, Wali Kelas!')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        <!-- Kelas Anda -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#edf5e6] border-[#d6e8c3]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Kelas Anda</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $class->class_name }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Tahun Ajaran {{ $class->academic_year }}</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#6a874c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#eff6ff] border-[#bfdbfe]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Total Siswa</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $totalSiswa }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Siswa terdaftar</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#3b82f6]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>

        <!-- Total Kandidat -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#fff3e3] border-[#fce0c2]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Total Kandidat</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ count($candidates) }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Kandidat terdaftar</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#f59e0b]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
        </div>

        <!-- Suara Masuk -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#f5eeff] border-[#e2d2ff]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Suara Masuk</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $sudahVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $pct }}% Partisipasi</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#a855f7]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Grafik & Voting Progress -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- Grafik Voting -->
        <div class="lg:col-span-3 bg-white rounded-xl border border-[#f0f0f0] pt-4 px-5 pb-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col justify-between min-h-[350px]">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-[#1f2937] font-medium text-[17px]">Grafik Partisipasi Suara</h2>
                <span class="flex items-center gap-1.5 text-[11px] font-bold text-[#10b981] bg-[#ecfdf5] px-3 py-1 rounded-full"><span class="w-1.5 h-1.5 bg-[#10b981] rounded-full animate-ping"></span> Real-time</span>
            </div>
            <div class="flex-1 flex items-center justify-center relative">
                <div id="dashboardDonutChart" class="w-full"></div>
            </div>
        </div>

        <!-- Voting Sedang Berlangsung -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-[#f0f0f0] pt-4 px-5 pb-5 shadow-[0_2px_15px_rgba(0,0,0,0.02)] flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-[#1f2937] font-medium text-[17px]">Status Pemilihan Kelas</h2>
                    <a href="/walikelas/voting-results" class="text-[13px] text-[#6a874c] font-medium hover:underline">Lihat Hasil</a>
                </div>

                <div class="bg-[#fafbf7] border border-[#f1f4eb] rounded-xl p-6 relative overflow-hidden mb-4">
                    <div class="flex items-start justify-between mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-[52px] h-[52px] rounded-xl bg-[#edf4e3] flex items-center justify-center font-bold text-[#405834]">
                                {{ $class->class_name }}
                            </div>
                            <div>
                                <p class="text-[15px] font-medium text-[#1f2937] mb-1">Ketua Kelas {{ $class->class_name }}</p>
                                <p class="text-[13px] font-medium text-[#6b7280]">Tahun Ajaran: {{ $class->academic_year }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-[#405834] bg-[#edf4e3] px-3.5 py-1.5 rounded-full whitespace-nowrap">Berlangsung</span>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[13px] font-bold text-[#4b5563]">Progress Voting</span>
                            <span class="text-[14px] font-bold text-[#6a874c]">{{ $pct }}%</span>
                        </div>
                        <div class="w-full h-2.5 bg-[#f0f4e8] rounded-full overflow-hidden mb-3">
                            <div class="h-full bg-[#6a874c] rounded-full" style="width: {{ $pct }}%;"></div>
                        </div>
                        <p class="text-[12px] font-medium text-[#6b7280]">{{ $sudahVoting }} / {{ $totalSiswa }} siswa sudah memberikan suara</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Grid: Hasil Voting & Ringkasan Standings -->
    <div class="bg-white rounded-xl border border-[#f0f0f0] p-6 shadow-sm mt-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-[#1f2937] font-medium text-[17px]">Hasil Voting Sementara</h2>
            <a href="/walikelas/voting-results" class="text-[13px] text-[#6a874c] font-medium hover:underline">Lihat Detail Klasemen</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($candidates as $index => $c)
            @php
                $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
                $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100) : 0;
            @endphp
            <!-- Card -->
            <div class="bg-white rounded-xl border border-[#f0f0f0] p-4 relative overflow-hidden flex flex-col justify-between h-full shadow-sm hover:border-[#d6e8c3] transition-colors">
                <div class="flex items-start gap-3">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#edf5e6] to-[#d6e8c3] flex items-center justify-center overflow-hidden">
                            @if($c->photo)
                                <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c->name) }}&background=edf5e6&color=405834&bold=true" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute -top-1 -left-1 w-6 h-6 rounded-full bg-[#6a874c] text-white flex items-center justify-center text-[12px] font-bold border-2 border-white shadow-sm">{{ $index + 1 }}</div>
                    </div>
                    <div class="pt-1">
                        <p class="text-[13px] font-bold text-[#1f2937] leading-tight mb-1">{{ $c->name }}</p>
                        <p class="text-[11px] font-medium text-[#6b7280]">No. Urut {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-[24px] font-bold text-[#405834] leading-none mb-1">{{ $candidatePct }}%</p>
                    <p class="text-[10px] font-medium text-[#6b7280] mb-3">{{ $votes }} suara</p>
                    <div class="w-full h-2 bg-[#f0f4e8] rounded-full overflow-hidden">
                        <div class="h-full bg-[#6a874c] rounded-full" style="width: {{ $candidatePct }}%;"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 py-6 text-center text-[#9ca3af] font-medium text-[14px]">
                Belum ada kandidat terdaftar di kelas ini.
            </div>
            @endforelse
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var chartLabels = [];
    var chartSeries = [];
    @foreach($results as $res)
        chartLabels.push("{{ $res['name'] }}");
        chartSeries.push({{ $res['votes'] }});
    @endforeach

    if (chartSeries.length === 0 || chartSeries.reduce((a, b) => a + b, 0) === 0) {
        chartLabels = ['Belum ada suara'];
        chartSeries = [1];
    }

    var options = {
        series: chartSeries,
        labels: chartLabels,
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#405834', '#d5b263', '#8c9c72', '#a855f7', '#3b82f6'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '12px'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Suara',
                            formatter: function (w) {
                                let total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                return (chartLabels[0] === 'Belum ada suara' && total === 1) ? 0 : total;
                            }
                        }
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#dashboardDonutChart"), options);
    chart.render();
});
</script>
@endsection
