@extends('admin.layouts.app')

@section('title', 'Kelola Wali Kelas')
@section('page-title', 'Kelola Wali Kelas')
@section('page-subtitle', 'Buat akun wali kelas dan tugaskan mereka ke kelas yang ada.')

@section('content')

    <!-- Rekap Cepat -->
    @php
    $total = count($walikelas);
    $sudahDitugaskan = collect($walikelas)->whereNotNull('class_id')->count();
    $belumDitugaskan = collect($walikelas)->whereNull('class_id')->count();
    $totalKelas = count($classes);
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#fdf9ef] flex items-center justify-center text-[#d5b263]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Total Guru</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#edf5e6] flex items-center justify-center text-[#405834]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Sudah Ditugaskan</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $sudahDitugaskan }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#fef2f2] flex items-center justify-center text-[#ef4444]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Belum Ditugaskan</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $belumDitugaskan }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-5 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-[#f5f5f5] flex items-center justify-center text-[#6e7568]">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <h3 class="text-[#aab2a3] font-bold text-[13px] uppercase tracking-wide">Total Kelas</h3>
            </div>
            <p class="text-[28px] font-extrabold text-[#2f3d20] leading-none mb-1">{{ $totalKelas }}</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-[#fdf9ef] border border-[#f5e6c3] text-[#c49a40] px-4 py-3 rounded-xl mb-6 flex items-center gap-2.5 text-[14px] font-medium shadow-sm">
            <svg class="w-5 h-5 text-[#d5b263] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <form action="{{ route('admin.walikelas') }}" method="GET" class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#aab2a3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari wali kelas..." class="w-full pl-10 pr-4 py-2 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[14px] text-[#405834] placeholder-[#aab2a3] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all" onchange="this.form.submit()">
                </form>
            </div>

            <!-- Add Button -->
            <button onclick="openAddModal()" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-[#d5b263] hover:bg-[#c49a40] text-white px-5 py-2.5 rounded-xl font-bold text-[14px] transition-colors shadow-sm">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" y1="8" x2="19" y2="14"></line>
                    <line x1="22" y1="11" x2="16" y2="11"></line>
                </svg>
                Tambah Wali Kelas
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#fafaf7] border-b border-[#e8e0c8]">
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">NIP/Username</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider">Ditugaskan di Kelas</th>
                        <th class="px-6 py-4 text-[12px] font-extrabold text-[#aab2a3] uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f5f5f5]">

                    @forelse($walikelas as $wk)
                    <tr class="hover:bg-[#fdf9ef] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-[#e8e0c8]">
                                    <img src="{{ $wk->avatar ? asset('storage/' . $wk->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($wk->name) . '&background=edf5e6&color=405834&bold=true' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-[14px] font-bold text-[#1f2937]">{{ $wk->name }}</p>
                                    <p class="text-[12px] text-[#6e7568]">Wali Kelas</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[14px] text-[#6e7568] font-medium font-mono">{{ $wk->nis_nip }}</td>
                        <td class="px-6 py-4 text-[14px] text-[#6e7568] font-medium">{{ $wk->email }}</td>
                        <td class="px-6 py-4">
                            @if($wk->class)
                                <span class="inline-flex items-center gap-1.5 text-[13px] font-bold text-[#405834] bg-[#edf5e6] px-3 py-1.5 rounded-lg border border-[#d6e8c3]">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                    {{ $wk->class->class_name }}
                                </span>
                            @else
                                <span class="text-[12px] font-bold text-red-500 bg-red-50 px-2.5 py-1 rounded-md border border-red-200">Belum di-assign</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEditModal({{ $wk->id }}, '{{ $wk->name }}', '{{ $wk->nis_nip }}', '{{ $wk->email }}', '{{ $wk->class_id }}', '{{ $wk->avatar }}')" class="p-1.5 bg-white border border-[#e8e0c8] rounded-lg text-[#8c9c72] hover:text-[#405834] hover:bg-[#edf5e6] hover:border-[#d6e8c3] transition-colors" title="Edit Data">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <form action="{{ route('admin.walikelas.delete', $wk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun wali kelas ini?')" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 bg-white border border-[#e8e0c8] rounded-lg text-red-400 hover:text-red-600 hover:bg-red-50 hover:border-red-200 transition-colors" title="Hapus Akun">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-[#9ca3af] font-medium text-[14px]">
                            Tidak ada data Wali Kelas ditemukan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== MODAL TAMBAH WALI KELAS ===== -->
    <div id="addWaliModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="addWaliModalContent">
            <h3 class="text-[17px] font-bold text-[#1f2937] mb-4">Tambah Wali Kelas Baru</h3>
            <form action="{{ route('admin.walikelas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap Guru <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso, S.Pd." class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Foto Profil (Opsional)</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full px-4 py-2 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIP / Username <span class="text-red-500">*</span></label>
                        <input type="text" name="nis_nip" required placeholder="NIP Guru" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Ditugaskan di Kelas</label>
                        <select name="class_id" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                            <option value="">Belum ditugaskan</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="budi@vooting.com" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Kata Sandi <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="Min. 6 Karakter" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-lg text-[13px] font-bold text-[#6b7280] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-[#d5b263] hover:bg-[#c49a40] shadow-sm transition-colors">Simpan Wali Kelas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT WALI KELAS ===== -->
    <div id="editWaliModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="editWaliModalContent">
            <h3 class="text-[17px] font-bold text-[#1f2937] mb-4">Edit Wali Kelas</h3>
            <form id="editWaliForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap Guru <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Foto Profil (Kosongkan jika tidak diubah)</label>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden border border-[#e8e0c8] bg-gray-50 flex items-center justify-center shrink-0">
                            <img id="edit_avatar_preview" src="" class="w-full h-full object-cover hidden">
                            <div id="edit_avatar_placeholder" class="text-[12px] font-bold text-gray-400">N/A</div>
                        </div>
                        <input type="file" name="avatar" accept="image/*" class="w-full px-4 py-2 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIP / Username <span class="text-red-500">*</span></label>
                        <input type="text" name="nis_nip" id="edit_nis_nip" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Ditugaskan di Kelas</label>
                        <select name="class_id" id="edit_class_id" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                            <option value="">Belum ditugaskan</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Kata Sandi (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" placeholder="Min. 6 Karakter" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#d5b263] focus:border-transparent transition-all">
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg text-[13px] font-bold text-[#6b7280] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-[#d5b263] hover:bg-[#c49a40] shadow-sm transition-colors">Perbarui Wali Kelas</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openAddModal() {
        const modal = document.getElementById('addWaliModal');
        const content = document.getElementById('addWaliModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeAddModal() {
        const modal = document.getElementById('addWaliModal');
        const content = document.getElementById('addWaliModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openEditModal(id, name, nisNip, email, classId, avatar) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_nis_nip').value = nisNip;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_class_id').value = classId || "";
        document.getElementById('editWaliForm').action = "/admin/walikelas/" + id + "/update";

        const previewImg = document.getElementById('edit_avatar_preview');
        const placeholderDiv = document.getElementById('edit_avatar_placeholder');
        if (avatar && avatar !== 'null' && avatar !== 'undefined' && avatar !== '') {
            previewImg.src = "/storage/" + avatar;
            previewImg.classList.remove('hidden');
            placeholderDiv.classList.add('hidden');
        } else {
            previewImg.classList.add('hidden');
            placeholderDiv.classList.remove('hidden');
        }

        const modal = document.getElementById('editWaliModal');
        const content = document.getElementById('editWaliModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeEditModal() {
        const modal = document.getElementById('editWaliModal');
        const content = document.getElementById('editWaliModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }
</script>
@endsection
