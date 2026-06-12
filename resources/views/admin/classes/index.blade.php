@extends('admin.layouts.app')

@section('title', 'Kelola Kelas')
@section('page-title', 'Kelola Kelas')
@section('page-subtitle', 'Tambahkan, ubah, atau hapus daftar kelas yang berpartisipasi dalam pemilihan.')

@section('content')

    <!-- Rekap Cepat -->
    @php
    $total = count($classes);
    $totalSiswa = collect($classes)->sum('siswa');
    $kelasKosong = collect($classes)->where('siswa', 0)->count();
    $waliKosong = collect($classes)->whereNull('wali')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#edf5e6] flex items-center justify-center text-[#405834]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Total Kelas</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#fdf9ef] flex items-center justify-center text-[#d5b263]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Total Siswa</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#fef2f2] flex items-center justify-center text-[#ef4444]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Kelas Kosong</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $kelasKosong }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#f5f5f5] flex items-center justify-center text-[#6e7568]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Tanpa Wali Kelas</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $waliKosong }}</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-[#edf5e6] border border-[#d6e8c3] text-[#405834] px-4 py-3 rounded-xl mb-6 flex items-center gap-2.5 text-[14px] font-medium shadow-sm">
            <svg class="w-5 h-5 text-[#8c9c72] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-[#e8e0c8] shadow-sm overflow-hidden mb-8">
        
        <!-- Header & Action Wrapped Inside Card -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-5 border-b border-[#f5f5f5]">
            <!-- Search & Filter -->
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <form action="{{ route('admin.classes') }}" method="GET" class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#aab2a3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..." class="w-full pl-10 pr-4 py-2 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[14px] text-[#405834] placeholder-[#aab2a3] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all" onchange="this.form.submit()">
                </form>
            </div>

            <!-- Add Button -->
            <button onclick="openAddModal()" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#405834] hover:bg-[#2f3d20] text-white px-5 py-2.5 rounded-xl font-bold text-[14px] transition-colors shadow-sm">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Kelas
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fafaf7] border-b border-[#e8e0c8]">
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Nama Kelas</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Tingkat</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Tahun Ajaran</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider text-center">Siswa</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Wali Kelas</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f5f5f5]">
                    
                    @forelse($classes as $cls)
                    <tr class="hover:bg-[#fdf9ef] transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-[14px] font-bold text-[#1f2937]">{{ $cls['name'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-[#6e7568] font-medium">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-[#edf5e6] text-[#405834] text-[11px] font-bold">{{ $cls['tingkat'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-[#6e7568] font-medium">{{ $cls['academic_year'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[32px] h-8 bg-[#f5f5f5] text-[#1f2937] text-[12px] font-bold rounded-lg border border-[#e8e0c8]">
                                {{ $cls['siswa'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($cls['wali'])
                                <div class="flex items-center gap-2 text-[13px] font-medium text-[#1f2937]">
                                    <div class="w-6 h-6 rounded-full bg-[#fdf9ef] flex items-center justify-center border border-[#e8e0c8] text-[#d5b263] text-[10px] font-bold">
                                        {{ substr($cls['wali'], 0, 1) }}
                                    </div>
                                    {{ $cls['wali'] }}
                                </div>
                            @else
                                <span class="text-[12px] italic text-[#9ca3af]">Belum ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEditModal({{ $cls['id'] }}, '{{ $cls['name'] }}', '{{ $cls['academic_year'] }}')" class="p-1.5 bg-white border border-[#e8e0c8] rounded-lg text-[#8c9c72] hover:text-[#405834] hover:bg-[#edf5e6] hover:border-[#d6e8c3] transition-colors" title="Edit Data">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <form action="{{ route('admin.classes.delete', $cls['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini beserta semua data di dalamnya?')" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-white border border-[#e8e0c8] rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 hover:border-red-200 transition-colors" title="Hapus Kelas">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-[#9ca3af] font-medium text-[14px]">
                            Belum ada data kelas yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== MODAL TAMBAH KELAS ===== -->
    <div id="addClassModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="bg-white rounded-2xl w-full max-w-md p-6 relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="addClassModalContent">
            <h3 class="text-[17px] font-bold text-[#1f2937] mb-4">Tambah Kelas Baru</h3>
            <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="class_name" required placeholder="Contoh: XII RPL 1" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#405834] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="academic_year" required placeholder="Contoh: 2024/2025" value="2024/2025" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#405834] focus:border-transparent transition-all">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-lg text-[13px] font-bold text-[#6b7280] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-[#405834] hover:bg-[#2f3d20] shadow-sm transition-colors">Simpan Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT KELAS ===== -->
    <div id="editClassModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="bg-white rounded-2xl w-full max-w-md p-6 relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="editClassModalContent">
            <h3 class="text-[17px] font-bold text-[#1f2937] mb-4">Edit Data Kelas</h3>
            <form id="editClassForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="class_name" id="edit_class_name" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#405834] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="academic_year" id="edit_academic_year" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#405834] focus:border-transparent transition-all">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg text-[13px] font-bold text-[#6b7280] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-[#405834] hover:bg-[#2f3d20] shadow-sm transition-colors">Perbarui Kelas</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openAddModal() {
        const modal = document.getElementById('addClassModal');
        const content = document.getElementById('addClassModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeAddModal() {
        const modal = document.getElementById('addClassModal');
        const content = document.getElementById('addClassModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openEditModal(id, name, year) {
        document.getElementById('edit_class_name').value = name;
        document.getElementById('edit_academic_year').value = year;
        document.getElementById('editClassForm').action = "/admin/classes/" + id + "/update";

        const modal = document.getElementById('editClassModal');
        const content = document.getElementById('editClassModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeEditModal() {
        const modal = document.getElementById('editClassModal');
        const content = document.getElementById('editClassModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }
</script>
@endsection
