@extends('siswa.layouts.app')

@section('title', 'Daftar Kandidat')
@section('page-title', 'Kandidat')
@section('page-subtitle', 'Daftar kandidat Ketua Kelas ' . $class->class_name)

@section('content')

    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight mb-1">Kandidat Ketua Kelas
                {{ $class->class_name }}
            </h2>
            <p class="text-[13px] font-medium text-[#6b7280]">Kenali visi dan misi setiap kandidat sebelum menentukan
                pilihan Anda.</p>
        </div>
        <a href="{{ route('siswa.vote') }}"
            class="bg-[#6a874c] hover:bg-black text-white text-[13px] font-bold px-5 py-2.5 rounded-lg flex items-center gap-2 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(106,135,76,0.3)] transition-all">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                <polyline points="9 11 12 14 22 4" />
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
            </svg>
            Berikan Suaraku
        </a>
    </div>

    <!-- Candidate Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse($candidates as $index => $c)
            <!-- Candidate Card -->
            <div
                class="bg-[#1ABC9C] rounded-xl border border-[#e8e0c8] overflow-hidden hover:shadow-lg transition-shadow flex flex-col justify-between">
                <div class="p-6">
                    <!-- Profile Image & No Urut -->
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-16 h-16 rounded-full overflow-hidden border border-[#4BBB04] bg-[#] flex-shrink-0">
                            @if($c->photo)
                                <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-full object-cover"
                                    alt="{{ $c->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c->name) }}&background=edf5e6&color=#4BBB04&size=64&bold=true"
                                    class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <span
                                class="inline-flex bg-[#1ABC9C] text-[#FFFFFF] text-[11px] font-extrabold px-2.5 py-0.5 rounded-full mb-1">No.
                                Urut {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="text-[15px] font-bold text-[#2f3d20] leading-tight">{{ $c->name }}</h3>
                            <p class="text-[11px] text-[#8c9c72] mt-0.5">NIS: {{ $c->nis }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-3 border-t border-[#fdf9ef]">
                        <div>
                            <h4 class="text-[12px] font-bold text-[#FFFFFF] uppercase tracking-wider mb-1">Visi</h4>
                            <p class="text-[13px] text-[#6e7568] leading-relaxed">"{{ $c->visi ?? 'Belum mengisi visi.' }}"</p>
                        </div>
                        <div>
                            <h4 class="text-[12px] font-bold text-[#8c9c72] uppercase tracking-wider mb-1">Misi</h4>
                            @if($c->misi)
                                <ul class="text-[12px] text-[#6e7568] space-y-1.5 list-disc pl-4 leading-relaxed">
                                    @foreach(explode("\n", str_replace("\r", "", $c->misi)) as $misiLine)
                                        @if(trim($misiLine))
                                            <li>{{ ltrim(trim($misiLine), '-*•1234567890. ') }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-[12px] text-[#6e7568]">Belum mengisi misi.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-[#fafbf8] border-t border-[#e8e0c8] flex items-center justify-end">
                    <a href="{{ route('siswa.vote') }}"
                        class="text-[12px] font-bold text-[#6a874c] hover:text-[#5a7440] flex items-center gap-1">
                        Pilih {{ explode(' ', trim($c->name))[0] }}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="md:col-span-3 py-12 text-center text-[#9ca3af]">
                <p class="font-medium text-[15px]">Belum ada kandidat aktif untuk kelas ini.</p>
            </div>
        @endforelse

    </div>

@endsection