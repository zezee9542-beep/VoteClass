@extends('walikelas.layouts.app')

@section('page-title', 'Kelas')
@section('page-subtitle', 'Informasi detail mengenai kelas Anda')

@section('content')

    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Informasi Kelas 9A</h2>
        <p class="text-[13px] font-medium text-[#6b7280]">Periode Kepengurusan & Data Tahun Ajaran 2024/2025</p>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Wali Kelas -->
        <div class="stat-card flex items-center justify-between">
            <div>
                <p class="text-[12px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Wali Kelas</p>
                <p class="text-[16px] font-bold text-[#2f3d20] leading-snug">Sri Wahyuni, S.Pd.</p>
                <p class="text-[11px] font-medium text-[#aab2a3] mt-1">NIP: 198504122010012003</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#fdf9ef] border border-[#e8e0c8] flex items-center justify-center text-[#405834] flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
        </div>

        <!-- Jumlah Siswa -->
        <div class="stat-card flex items-center justify-between">
            <div>
                <p class="text-[12px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Jumlah Siswa</p>
                <p class="text-[28px] font-bold text-[#2f3d20] leading-none mb-1">36</p>
                <p class="text-[11px] font-medium text-[#aab2a3]">Siswa Terdaftar aktif</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#fdf9ef] border border-[#e8e0c8] flex items-center justify-center text-[#405834] flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>

        <!-- Ketua Kelas Sekarang -->
        <div class="stat-card flex items-center justify-between">
            <div>
                <p class="text-[12px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Ketua Kelas (Demisioner)</p>
                <p class="text-[16px] font-bold text-[#2f3d20] leading-snug">Budi Prasetyo</p>
                <p class="text-[11px] font-medium text-[#aab2a3] mt-1">NIS: 230101007</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#fdf9ef] border border-[#e8e0c8] flex items-center justify-center text-[#405834] flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            </div>
        </div>

        <!-- Akreditasi Kelas -->
        <div class="stat-card flex items-center justify-between">
            <div>
                <p class="text-[12px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Akreditasi / Ruang</p>
                <p class="text-[20px] font-bold text-[#2f3d20] leading-none mb-1">Grade A / R.304</p>
                <p class="text-[11px] font-medium text-[#aab2a3]">Gedung B Lantai 3</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#fdf9ef] border border-[#e8e0c8] flex items-center justify-center text-[#405834] flex-shrink-0">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
        </div>

    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kiri: Struktur Organisasi (2 Col) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-[#e8e0c8] p-6 shadow-sm">
            <h3 class="text-[#2f3d20] font-bold text-[16px] mb-5 pb-3 border-b border-[#e8e0c8] flex items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#8c9c72]"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Struktur Organisasi Kelas 9A (2023/2024)
            </h3>
            
            <!-- Tree Layout / Card Hierarchy -->
            <div class="flex flex-col gap-6">
                <!-- Wali Kelas -->
                <div class="flex justify-center">
                    <div class="bg-[#fdf9ef] border border-[#d5b263] rounded-xl p-4 w-[260px] text-center shadow-sm">
                        <p class="text-[11px] font-bold text-[#8c9c72] uppercase tracking-widest mb-1.5">Wali Kelas</p>
                        <p class="text-[14px] font-bold text-[#2f3d20]">Sri Wahyuni, S.Pd.</p>
                        <p class="text-[11px] text-[#6e7568] mt-0.5">Pembina Utama</p>
                    </div>
                </div>

                <!-- Link Line -->
                <div class="h-4 w-0.5 bg-[#d5b263] mx-auto -my-6"></div>

                <!-- Ketua & Wakil -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                    <div class="bg-white border border-[#e8e0c8] rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                        <p class="text-[10px] font-bold text-[#8c9c72] uppercase mb-1">Ketua Kelas</p>
                        <p class="text-[13px] font-bold text-[#2f3d20]">Budi Prasetyo</p>
                        <p class="text-[11px] text-[#aab2a3] mt-0.5">NIS: 230101007</p>
                    </div>
                    <div class="bg-white border border-[#e8e0c8] rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                        <p class="text-[10px] font-bold text-[#8c9c72] uppercase mb-1">Wakil Ketua Kelas</p>
                        <p class="text-[13px] font-bold text-[#2f3d20]">Rafael Pratama</p>
                        <p class="text-[11px] text-[#aab2a3] mt-0.5">NIS: 230101001</p>
                    </div>
                </div>

                <!-- Sekretaris & Bendahara -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white border border-[#e8e0c8] rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                        <p class="text-[10px] font-bold text-[#8c9c72] uppercase mb-1">Sekretaris</p>
                        <p class="text-[13px] font-bold text-[#2f3d20]">Aisyah Zahra</p>
                        <p class="text-[11px] text-[#aab2a3] mt-0.5">NIS: 230101002</p>
                    </div>
                    <div class="bg-white border border-[#e8e0c8] rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                        <p class="text-[10px] font-bold text-[#8c9c72] uppercase mb-1">Bendahara</p>
                        <p class="text-[13px] font-bold text-[#2f3d20]">Nabila Putri</p>
                        <p class="text-[11px] text-[#aab2a3] mt-0.5">NIS: 230101004</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Jadwal Piket (1 Col) -->
        <div class="lg:col-span-1 bg-white rounded-xl border border-[#e8e0c8] p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-[#2f3d20] font-bold text-[16px] mb-5 pb-3 border-b border-[#e8e0c8] flex items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#8c9c72]"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Piket Kelas
                </h3>
                
                <div class="space-y-3">
                    <div class="p-3 bg-[#fdf9ef] border border-[#f0e8d0] rounded-xl">
                        <p class="text-[12px] font-bold text-[#405834] mb-1">Senin</p>
                        <p class="text-[12px] font-medium text-[#6e7568]">Rafael P., Aisyah Z., Dimas W., Nabila P.</p>
                    </div>
                    <div class="p-3 bg-[#fdf9ef] border border-[#f0e8d0] rounded-xl">
                        <p class="text-[12px] font-bold text-[#405834] mb-1">Selasa</p>
                        <p class="text-[12px] font-medium text-[#6e7568]">Fahri A., Siti R., Budi P., Ahmad F.</p>
                    </div>
                    <div class="p-3 bg-[#fdf9ef] border border-[#f0e8d0] rounded-xl">
                        <p class="text-[12px] font-bold text-[#405834] mb-1">Rabu</p>
                        <p class="text-[12px] font-medium text-[#6e7568]">Dewi S., Eko K., Farhan M., Gita A.</p>
                    </div>
                    <div class="p-3 bg-[#fdf9ef] border border-[#f0e8d0] rounded-xl">
                        <p class="text-[12px] font-bold text-[#405834] mb-1">Kamis</p>
                        <p class="text-[12px] font-medium text-[#6e7568]">Hendra B., Indah P., Joko W., Kartika D.</p>
                    </div>
                    <div class="p-3 bg-[#fdf9ef] border border-[#f0e8d0] rounded-xl">
                        <p class="text-[12px] font-bold text-[#405834] mb-1">Jumat</p>
                        <p class="text-[12px] font-medium text-[#6e7568]">Lani N., Mega W., Novi T., Oki P.</p>
                    </div>
                </div>
            </div>
            
            <p class="text-[11px] text-[#aab2a3] text-center mt-6">Harap menjaga kebersihan dan ketertiban ruang kelas bersama.</p>
        </div>

    </div>

@endsection
