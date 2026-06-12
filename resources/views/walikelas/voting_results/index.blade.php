@extends('walikelas.layouts.app')

@section('page-title', 'Hasil Voting')
@section('page-subtitle', 'Hasil real-time perolehan suara pemilihan ketua kelas')

@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Hasil Pemilihan Ketua Kelas {{ $class->class_name }}</h2>
            <p class="text-[13px] font-medium text-[#6b7280]">Real-time perolehan suara kelas Wali Anda</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Export CSV Button -->
            <a href="{{ route('walikelas.voting-results.export') }}" class="bg-[#edf5e6] border border-[#d6e8c3] text-[#405834] text-[13px] font-bold px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#d6e8c3] transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Ekspor CSV
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#eff6ff] border-[#bfdbfe]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-2">Total Pemilih</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-2 tracking-tight">{{ $totalSiswa }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Siswa terdaftar</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 text-[#3b82f6]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#edf5e6] border-[#d6e8c3]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-2">Suara Masuk</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-2 tracking-tight">{{ $sudahVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $pct }}% Partisipasi</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 text-[#6a874c]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
        </div>
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#fff3e3] border-[#fce0c2]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-2">Belum Memilih</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-2 tracking-tight">{{ $belumVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Siswa belum memilih</p>
            </div>
            <div class="w-[60px] h-[60px] rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0 text-[#f59e0b]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
        </div>
    </div>

    <!-- Result Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        
        <!-- Left: Apex Chart (3 Cols) -->
        <div class="lg:col-span-3 bg-white rounded-xl border border-[#f0f0f0] p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-[#2f3d20] font-bold text-[16px] mb-4">Grafik Perolehan Suara</h3>
                <div class="w-full relative flex items-center justify-center min-h-[300px]">
                    @if(count($candidates) > 0)
                        <div id="resultsChart" class="w-full"></div>
                    @else
                        <div class="flex flex-col items-center gap-3 text-[#9ca3af]">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                            <p class="font-medium text-[14px]">Belum ada kandidat</p>
                            <p class="text-[12px]">Tambahkan kandidat untuk melihat grafik</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="pt-4 border-t border-[#f0f0f0] flex items-center justify-between text-[#8c9c72] text-[12px] font-medium">
                <span id="lastUpdatedText">Diperbarui: baru saja</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 bg-[#6a874c] rounded-full animate-ping"></span> Real-time aktif</span>
            </div>
        </div>

        <!-- Right: Standings List (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-[#f0f0f0] p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-[#2f3d20] font-bold text-[16px] mb-4">Klasemen Kandidat</h3>
                
                <div class="space-y-3" id="standingsList">
                    @forelse($candidates as $index => $c)
                    @php
                        $isLeading = $index === 0 && $c['votes'] > 0;
                    @endphp
                    <div class="p-3 border {{ $isLeading ? 'border-[#d6e8c3] bg-[#f8fbf5]' : 'border-[#f0f0f0]' }} rounded-xl relative overflow-hidden hover:border-[#d6e8c3] transition-colors">
                        <div class="flex items-start gap-3 relative z-10">
                            <div class="w-12 h-12 rounded-full overflow-hidden border {{ $isLeading ? 'border-[#d6e8c3]' : 'border-[#e8e0c8]' }} bg-white flex-shrink-0">
                                @if($c['photo'])
                                    <img src="{{ asset('storage/' . $c['photo']) }}" class="w-full h-full object-cover" alt="{{ $c['name'] }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=edf5e6&color=405834&bold=true" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-[13px] font-bold text-[#2f3d20]">{{ $c['name'] }}</h4>
                                    <span class="text-[14px] font-extrabold text-[#6a874c]">{{ $c['pct'] }}%</span>
                                </div>
                                <p class="text-[11px] text-[#6e7568] mt-0.5">NIS: {{ $c['nis'] }} · No. Urut {{ $c['no_urut'] }}</p>
                                <div class="w-full h-2 bg-[#f0f4e8] rounded-full overflow-hidden mt-2">
                                    <div class="h-full bg-[#6a874c] rounded-full transition-all duration-500" style="width: {{ $c['pct'] }}%;"></div>
                                </div>
                                <p class="text-[10px] font-bold text-[#8c9c72] mt-1.5">{{ $c['votes'] }} Suara Masuk</p>
                            </div>
                        </div>
                        <div class="absolute -right-2 -bottom-4 text-[64px] font-extrabold {{ $isLeading ? 'text-[#edf5e6]' : 'text-[#fafbf7]' }} select-none pointer-events-none z-0">{{ $c['no_urut'] }}</div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-[#9ca3af]">
                        <p class="font-medium text-[14px]">Belum ada kandidat terdaftar.</p>
                        <a href="{{ route('walikelas.candidates') }}" class="text-[13px] text-[#6a874c] hover:underline mt-1 inline-block">Tambah kandidat</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Stats Footer -->
            <div class="pt-4 mt-6 border-t border-[#f0f0f0] grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-[20px] font-bold text-[#2f3d20]">{{ $sudahVoting }} / {{ $totalSiswa }}</p>
                    <p class="text-[10px] font-bold text-[#8c9c72] uppercase tracking-wider">Total Partisipan</p>
                </div>
                <div>
                    <p class="text-[20px] font-bold text-[#2f3d20]">{{ $pct }}%</p>
                    <p class="text-[10px] font-bold text-[#8c9c72] uppercase tracking-wider">Persentase Suara</p>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var chartLabels = @json($chartLabels);
    var chartSeries = @json($chartSeries);

    if (chartSeries.length === 0 || chartSeries.reduce((a, b) => a + b, 0) === 0) {
        chartLabels = ['Belum ada suara'];
        chartSeries = [1];
    }

    var chartEl = document.querySelector("#resultsChart");
    if (!chartEl) return;

    var options = {
        series: chartSeries,
        labels: chartLabels,
        chart: {
            type: 'donut',
            height: 310,
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#405834', '#d5b263', '#8c9c72', '#a855f7', '#3b82f6', '#ef4444'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '12px',
            fontWeight: 500,
            markers: { radius: 12 }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                if (chartLabels[0] === 'Belum ada suara') return '';
                return val.toFixed(0) + "%";
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#6e7568',
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            fontWeight: 700,
                            color: '#2f3d20',
                            offsetY: 10,
                            formatter: function (val) {
                                if (chartLabels[0] === 'Belum ada suara') return '0';
                                return val + " suara";
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total Suara',
                            color: '#6e7568',
                            formatter: function (w) {
                                if (chartLabels[0] === 'Belum ada suara') return 0;
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(chartEl, options);
    chart.render();

    // Real-time polling every 30 seconds
    function pollRealtimeStats() {
        fetch("{{ route('walikelas.api.realtime-stats') }}")
            .then(r => r.json())
            .then(data => {
                // Update last updated text
                var el = document.getElementById('lastUpdatedText');
                if (el) el.textContent = 'Diperbarui: ' + data.lastUpdated + ' WIB';

                // Update chart if series changed
                var newSeries = data.chartSeries;
                var newLabels = data.chartLabels;
                if (newSeries.length === 0 || newSeries.reduce((a,b) => a+b, 0) === 0) {
                    newSeries = [1];
                    newLabels = ['Belum ada suara'];
                }
                chart.updateOptions({ labels: newLabels });
                chart.updateSeries(newSeries);
            })
            .catch(() => {});
    }

    setInterval(pollRealtimeStats, 30000);
});
</script>
@endsection
