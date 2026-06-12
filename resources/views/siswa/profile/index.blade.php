@extends('siswa.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil')
@section('page-subtitle', 'Detail informasi akun Anda')

@section('content')

    <div class="max-w-2xl mx-auto">
        
        <!-- Profile Main Card -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] overflow-hidden shadow-sm mb-6">
            <!-- Header Background -->
            <div class="h-32 bg-gradient-to-r from-[#405834] to-[#6a874c]"></div>
            
            <!-- Profile Info Container -->
            <div class="px-6 pb-6 relative">
                <!-- Avatar Bubble -->
                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white bg-white shadow-md absolute -top-12 left-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=dbeafe&color=1d4ed8&size=96&bold=true" class="w-full h-full object-cover">
                </div>
                
                <!-- Spacer for avatar -->
                <div class="h-16"></div>
                
                <!-- Profile Name and Bio -->
                <div class="mb-6">
                    <h2 class="text-[20px] font-bold text-[#2f3d20] leading-none mb-1.5">{{ Auth::user()->name }}</h2>
                    <p class="text-[12px] font-semibold text-[#8c9c72] uppercase tracking-wider">Siswa Kelas {{ $class->class_name }}</p>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4 border-t border-[#fdf9ef]">
                    <div>
                        <p class="text-[11px] font-bold text-[#aab2a3] uppercase tracking-wider mb-1">Nomor Induk Siswa (NIS)</p>
                        <p class="text-[14px] font-bold text-[#2f3d20]">{{ Auth::user()->nis_nip }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[11px] font-bold text-[#aab2a3] uppercase tracking-wider mb-1">Email</p>
                        <p class="text-[14px] font-medium text-[#4b5563]">{{ Auth::user()->email }}</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-[#aab2a3] uppercase tracking-wider mb-1">Wali Kelas</p>
                        <p class="text-[14px] font-bold text-[#2f3d20]">{{ $wali ? $wali->name : 'Belum ditentukan' }}</p>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-[#aab2a3] uppercase tracking-wider mb-1">Tahun Akademik</p>
                        <p class="text-[14px] font-medium text-[#4b5563]">{{ $class->academic_year }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Voting Status Card -->
        <div class="bg-white rounded-2xl border border-[#e8e0c8] p-6 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($voted)
                <div class="w-12 h-12 rounded-full bg-[#f0fdf4] border border-[#bbf7d0] flex items-center justify-center text-[#16a34a] flex-shrink-0">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <h3 class="text-[#2f3d20] font-bold text-[14px] mb-0.5">Status Hak Pilih</h3>
                    <p class="text-[#6e7568] text-[12px]">Anda terdaftar aktif dan sudah menyalurkan suara pilihan.</p>
                </div>
                @else
                <div class="w-12 h-12 rounded-full bg-[#fef2f2] border border-[#fecaca] flex items-center justify-center text-[#ef4444] flex-shrink-0">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div>
                    <h3 class="text-[#2f3d20] font-bold text-[14px] mb-0.5">Status Hak Pilih</h3>
                    <p class="text-[#6e7568] text-[12px]">Anda terdaftar aktif dan belum menggunakan hak pilih.</p>
                </div>
                @endif
            </div>
            @if($voted)
            <span class="text-[11px] font-bold text-[#16a34a] bg-[#f0fdf4] border border-[#bbf7d0] px-3.5 py-1.5 rounded-full">
                Sudah Memilih
            </span>
            @else
            <a href="{{ route('siswa.vote') }}" class="text-[11px] font-bold text-[#ef4444] bg-[#fef2f2] border border-[#fecaca] px-3.5 py-1.5 rounded-full hover:bg-[#ef4444] hover:text-white transition-colors">
                Belum Memilih
            </a>
            @endif
        </div>

    </div>

@endsection
