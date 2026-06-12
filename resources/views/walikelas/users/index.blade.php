@extends('walikelas.layouts.app')

@section('page-title', 'Pengguna')
@section('page-subtitle', 'Kelola data siswa di kelas Anda')

@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Daftar Siswa Kelas {{ $class->class_name }}</h2>
            <p class="text-[13px] font-medium text-[#6b7280]">Total {{ $totalSiswa }} siswa terdaftar</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Filter Status Voting -->
            <form action="{{ route('walikelas.users') }}" method="GET" class="flex items-center gap-3">
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="appearance-none bg-white border border-[#e5e7eb] text-[#4b5563] text-[13px] font-medium rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="Sudah Voting" {{ request('status') === 'Sudah Voting' ? 'selected' : '' }}>Sudah Voting</option>
                        <option value="Belum Voting" {{ request('status') === 'Belum Voting' ? 'selected' : '' }}>Belum Voting</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6b7280]">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa..." class="w-full sm:w-[200px] pl-9 pr-4 py-2 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent" onchange="this.form.submit()">
                </div>
            </form>
            <!-- Tambah Button -->
            <button onclick="openModal('addUserModal')" class="bg-[#6a874c] hover:bg-[#5a7440] text-white text-[13px] font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(106,135,76,0.3)] transition-all duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </button>
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

        <!-- Total Siswa -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#eff6ff] border-[#bfdbfe]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Total Siswa</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $totalSiswa }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Kelas {{ $class->class_name }} terdaftar</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#3b82f6]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>

        <!-- Sudah Voting -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#edf5e6] border-[#d6e8c3]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Sudah Voting</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $sudahVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0 }}% dari total siswa</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#6a874c]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
        </div>

        <!-- Belum Voting -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#fff3e3] border-[#fce0c2]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Belum Voting</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $belumVoting }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">{{ $totalSiswa > 0 ? round(($belumVoting / $totalSiswa) * 100) : 0 }}% dari total siswa</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#f59e0b]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
        </div>

    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl border border-[#f0f0f0] shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#f0f0f0] bg-[#fafbf8]">
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5 w-[40px]">#</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Siswa</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Email</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Kelas</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Status Voting</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($users as $u)
                <tr class="border-b border-[#f0f0f0] hover:bg-[#fafbf8] transition-colors last:border-0">
                    <td class="px-6 py-4 text-[13px] font-bold text-[#6b7280]">{{ $u['no'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u['name']) }}&background=edf5e6&color=405834&size=36&bold=true"
                                 class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $u['name'] }}">
                            <div>
                                <p class="text-[13px] font-bold text-[#1f2937] leading-tight">{{ $u['name'] }}</p>
                                <p class="text-[11px] font-medium text-[#9ca3af]">NIS: {{ $u['nis'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-[13px] font-medium text-[#4b5563]">{{ $u['email'] }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-[13px] font-bold text-[#1f2937]">{{ $u['kelas'] }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($u['voted'])
                            <span class="text-[11px] font-bold text-[#16a34a] bg-[#f0fdf4] border border-[#bbf7d0] px-3 py-1 rounded-full">Sudah Voting</span>
                        @else
                            <span class="text-[11px] font-bold text-[#f59e0b] bg-[#fff3e3] border border-[#fce0c2] px-3 py-1 rounded-full">Belum Voting</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModal({{ $u['id'] }}, '{{ $u['name'] }}', '{{ $u['nis'] }}', '{{ $u['email'] }}')" class="w-8 h-8 rounded-lg bg-[#edf5e6] flex items-center justify-center hover:bg-[#d6e8c3] hover:-translate-y-0.5 transition-all duration-200" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6a874c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <form action="{{ route('walikelas.users.delete', $u['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')" class="inline">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-lg bg-[#fee2e2] flex items-center justify-center hover:bg-[#fecaca] hover:-translate-y-0.5 transition-all duration-200" title="Hapus">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-[#9ca3af] font-medium text-[14px]">
                        Tidak ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ===== MODAL TAMBAH PENGGUNA ===== -->
    <div id="addUserModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModal('addUserModal')"></div>

        <!-- Modal Content -->
        <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="addUserModalContent">

            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-[#f0f0f0] px-6 py-4 flex items-center justify-between z-20 rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#edf5e6] flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6a874c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    </div>
                    <h3 class="text-[17px] font-bold text-[#1f2937]">Tambah Siswa Baru</h3>
                </div>
                <button onclick="closeModal('addUserModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#9ca3af] hover:bg-[#f3f4f6] hover:text-[#4b5563] transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- Form Body -->
            <form action="{{ route('walikelas.users.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" required placeholder="Masukkan nama lengkap" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                    <!-- NIS / ID -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIS <span class="text-red-400">*</span></label>
                        <input type="text" name="nis_nip" required placeholder="Contoh: 230101001" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" required placeholder="contoh@siswa.vooting.com" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                </div>

                <!-- Kelas (Read-Only) -->
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Kelas</label>
                    <input type="text" value="{{ $class->class_name }}" disabled readonly class="w-full px-4 py-2.5 bg-[#f9fafb] border border-[#e5e7eb] rounded-lg text-[13px] font-semibold text-[#6b7280] focus:outline-none cursor-not-allowed">
                    <p class="text-[11px] text-[#9ca3af] mt-1">Siswa otomatis dimasukkan ke kelas Anda ({{ $class->class_name }})</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Password <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="passwordInput" required placeholder="Min. 6 karakter" class="w-full px-4 py-2.5 pr-10 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                        <button type="button" onclick="togglePass('passwordInput', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 flex items-center text-[#9ca3af] hover:text-[#4b5563]">
                            <svg id="eyeIcon1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-[#f0f0f0] mt-2">
                    <button type="button" onclick="closeModal('addUserModal')" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-[#4b5563] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] hover:-translate-y-0.5 transition-all duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-white bg-[#6a874c] hover:bg-[#5a7440] shadow-sm hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Siswa
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT PENGGUNA ===== -->
    <div id="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModal('editUserModal')"></div>

        <!-- Modal Content -->
        <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="editUserModalContent">

            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-[#f0f0f0] px-6 py-4 flex items-center justify-between z-20 rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#edf5e6] flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6a874c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h3 class="text-[17px] font-bold text-[#1f2937]">Edit Siswa</h3>
                </div>
                <button onclick="closeModal('editUserModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#9ca3af] hover:bg-[#f3f4f6] hover:text-[#4b5563] transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <!-- Form Body -->
            <form id="editUserForm" method="POST" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                    <!-- NIS -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIS <span class="text-red-400">*</span></label>
                        <input type="text" name="nis_nip" id="edit_nis" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" id="edit_email" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Password (Kosongkan jika tidak diubah)</label>
                    <div class="relative">
                        <input type="password" name="password" id="editPasswordInput" placeholder="Min. 6 karakter" class="w-full px-4 py-2.5 pr-10 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                        <button type="button" onclick="togglePass('editPasswordInput', 'editEyeIcon')" class="absolute inset-y-0 right-0 px-3 flex items-center text-[#9ca3af] hover:text-[#4b5563]">
                            <svg id="editEyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-[#f0f0f0] mt-2">
                    <button type="button" onclick="closeModal('editUserModal')" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-[#4b5563] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] hover:-translate-y-0.5 transition-all duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-white bg-[#6a874c] hover:bg-[#5a7440] shadow-sm hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Perbarui Siswa
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + 'Content');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const content = document.getElementById(id + 'Content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function openEditModal(id, name, nis, email) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_nis').value = nis;
        document.getElementById('edit_email').value = email;
        document.getElementById('editUserForm').action = "/walikelas/users/" + id + "/update";
        openModal('editUserModal');
    }

    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('addUserModal');
            closeModal('editUserModal');
        }
    });
</script>
@endsection
