@extends('walikelas.layouts.app')

@section('page-title', 'Kandidat')
@section('page-subtitle', 'Kelola data kandidat di kelas Anda')

@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Daftar Kandidat Kelas {{ $class->class_name }}</h2>
            <p class="text-[13px] font-medium text-[#6b7280]">Total {{ $totalKandidat }} kandidat terdaftar</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Search Bar -->
            <form action="{{ route('walikelas.candidates') }}" method="GET" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kandidat..." class="w-full sm:w-[220px] pl-9 pr-4 py-2 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent" onchange="this.form.submit()">
            </form>
            
            <!-- Add Button -->
            <button onclick="openModal('addCandidateModal')" class="bg-[#6a874c] hover:bg-[#5a7440] text-white text-[13px] font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(106,135,76,0.3)] transition-all duration-300">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Kandidat
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

    <!-- Alert Error -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-[13px] font-medium">
            <p class="font-bold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Total Kandidat -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#f5eeff] border-[#e2d2ff]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Total Kandidat</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $totalKandidat }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Terdaftar di {{ $class->class_name }}</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#a855f7]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
        </div>

        <!-- Kandidat Aktif -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#edf5e6] border-[#d6e8c3]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Kandidat Aktif</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $aktifKandidat }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Bisa dipilih siswa</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#6a874c]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
            </div>
        </div>

        <!-- Kandidat Nonaktif -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#fef2f2] border-[#fecaca]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Kandidat Nonaktif</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $nonaktifKandidat }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Ditangguhkan</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#ef4444]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>
            </div>
        </div>

        <!-- Kelas Pemilihan -->
        <div class="rounded-xl border p-5 flex items-center justify-between hover:-translate-y-1 transition-transform duration-300 bg-[#eff6ff] border-[#bfdbfe]">
            <div>
                <p class="text-[13px] font-bold text-[#4b5563] mb-3">Kelas Pemilihan</p>
                <p class="text-[32px] font-bold text-[#1f2937] leading-none mb-3 tracking-tight">{{ $class->class_name }}</p>
                <p class="text-[12px] font-medium text-[#6b7280]">Kelas Wali Anda</p>
            </div>
            <div class="w-[68px] h-[68px] rounded-full bg-white shadow-[0_2px_15px_rgba(0,0,0,0.03)] flex items-center justify-center flex-shrink-0 text-[#3b82f6]">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
        </div>

    </div>

    <!-- Candidates Table -->
    <div class="bg-white rounded-xl border border-[#f0f0f0] shadow-sm mt-6 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#f0f0f0]">
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4 w-[40px]">#</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Kandidat</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Kelas</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Visi & Misi</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Status</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Total Suara</th>
                    <th class="text-left text-[12px] font-bold text-[#1f2937] px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($candidates as $c)
                <tr class="border-b border-[#f0f0f0] hover:bg-[#fafbf8] transition-colors">
                    <td class="px-6 py-4 text-[13px] font-bold text-[#4b5563]">{{ $c['no'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 border border-[#e5e7eb] bg-[#edf5e6]">
                                @if($c['photo'])
                                    <img src="{{ asset('storage/' . $c['photo']) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($c['name']) }}&background=edf5e6&color=405834&bold=true" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-[#1f2937] leading-tight">{{ $c['name'] }}</p>
                                <p class="text-[11px] font-medium text-[#6b7280]">NIS: {{ $c['nis'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-[13px] font-bold text-[#1f2937]">{{ $class->class_name }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-w-[240px] text-[12px] text-[#4b5563]">
                            <p class="font-bold text-[#2f3d20]">Visi:</p>
                            <p class="italic mb-1">{{ $c['visi'] }}</p>
                            <p class="font-bold text-[#2f3d20]">Misi:</p>
                            <p class="whitespace-pre-line">{{ $c['misi'] }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($c['status'] === 'aktif')
                            <span class="text-[11px] font-bold text-[#6a874c] bg-[#edf5e6] px-3 py-1 rounded-full border border-[#d6e8c3]">Aktif</span>
                        @else
                            <span class="text-[11px] font-bold text-[#ef4444] bg-[#fef2f2] px-3 py-1 rounded-full border border-[#fecaca]">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-[14px] font-bold text-[#1f2937]">{{ $c['votes'] }}</p>
                        <p class="text-[11px] font-medium text-[#6b7280]">({{ $c['pct'] }}%)</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button onclick="openEditModal({{ $c['id'] }}, '{{ $c['name'] }}', '{{ $c['nis'] }}', '{{ addslashes($c['visi']) }}', '{{ addslashes($c['misi']) }}', '{{ $c['status'] }}')" class="w-8 h-8 rounded-lg bg-[#edf5e6] flex items-center justify-center hover:bg-[#d6e8c3] transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6a874c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <form action="{{ route('walikelas.candidates.delete', $c['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')" class="inline">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-lg bg-[#fee2e2] flex items-center justify-center hover:bg-[#fecaca] transition-colors">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-[#9ca3af] font-medium text-[14px]">
                        Belum ada kandidat terdaftar.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- ===== MODAL TAMBAH KANDIDAT ===== -->
    <div id="addCandidateModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModal('addCandidateModal')"></div>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="addCandidateModalContent">
            <div class="sticky top-0 bg-white border-b border-[#f0f0f0] px-6 py-4 flex items-center justify-between z-20">
                <h3 class="text-[17px] font-bold text-[#1f2937]">Tambah Kandidat Baru</h3>
                <button onclick="closeModal('addCandidateModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#9ca3af] hover:bg-[#f3f4f6] hover:text-[#4b5563] transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form action="{{ route('walikelas.candidates.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" required placeholder="Masukkan nama kandidat" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIS / NIM <span class="text-red-400">*</span></label>
                        <input type="text" name="nis" required placeholder="Masukkan NIS" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Status Keaktifan</label>
                        <select name="status" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-[13px] text-[#6b7280] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[13px] file:font-semibold file:bg-[#edf5e6] file:text-[#405834] hover:file:bg-[#d6e8c3]">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Visi</label>
                    <textarea name="visi" rows="3" placeholder="Tuliskan visi kandidat" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all"></textarea>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Misi</label>
                    <textarea name="misi" rows="4" placeholder="Tuliskan misi kandidat (gunakan baris baru untuk poin-poin)" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addCandidateModal')" class="px-5 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-bold text-[#4b5563] hover:bg-[#f9fafb]">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#6a874c] hover:bg-[#5a7440] rounded-lg text-[13px] font-bold text-white shadow-sm">Simpan Kandidat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT KANDIDAT ===== -->
    <div id="editCandidateModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModal('editCandidateModal')"></div>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="editCandidateModalContent">
            <div class="sticky top-0 bg-white border-b border-[#f0f0f0] px-6 py-4 flex items-center justify-between z-20">
                <h3 class="text-[17px] font-bold text-[#1f2937]">Edit Kandidat</h3>
                <button onclick="closeModal('editCandidateModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#9ca3af] hover:bg-[#f3f4f6] hover:text-[#4b5563] transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form id="editCandidateForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="edit_name" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">NIS / NIM <span class="text-red-400">*</span></label>
                        <input type="text" name="nis" id="edit_nis" required class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Status Keaktifan</label>
                        <select name="status" id="edit_status" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Foto Profil (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-[13px] text-[#6b7280] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[13px] file:font-semibold file:bg-[#edf5e6] file:text-[#405834] hover:file:bg-[#d6e8c3]">
                    </div>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Visi</label>
                    <textarea name="visi" id="edit_visi" rows="3" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all"></textarea>
                </div>

                <div>
                    <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Misi</label>
                    <textarea name="misi" id="edit_misi" rows="4" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('editCandidateModal')" class="px-5 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-bold text-[#4b5563] hover:bg-[#f9fafb]">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#6a874c] hover:bg-[#5a7440] rounded-lg text-[13px] font-bold text-white shadow-sm">Perbarui Kandidat</button>
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

    function openEditModal(id, name, nis, visi, misi, status) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_nis').value = nis;
        document.getElementById('edit_visi').value = visi;
        document.getElementById('edit_misi').value = misi;
        document.getElementById('edit_status').value = status;
        document.getElementById('editCandidateForm').action = "/walikelas/candidates/" + id + "/update";
        openModal('editCandidateModal');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('addCandidateModal');
            closeModal('editCandidateModal');
        }
    });
</script>
@endsection
