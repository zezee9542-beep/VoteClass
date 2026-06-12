@extends('walikelas.layouts.app')

@section('page-title', 'Tambah Kandidat')
@section('page-subtitle', 'Masukkan data kandidat baru')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('walikelas.candidates') }}" class="w-8 h-8 rounded-lg border border-[#e5e7eb] flex items-center justify-center text-[#4b5563] hover:bg-[#f9fafb] transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-[18px] font-bold text-[#1f2937] leading-tight">Tambah Kandidat Baru</h2>
        </div>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-[13px] space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-[#f0f0f0] shadow-sm overflow-hidden">
        <form action="{{ route('walikelas.candidates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Left Column: Photo Upload -->
                <div class="md:col-span-1 flex flex-col items-center">
                    <p class="text-[13px] font-bold text-[#1f2937] w-full mb-3">Foto Kandidat</p>
                    <div class="w-full relative group">
                        <label for="photo" class="flex flex-col items-center justify-center w-full h-[240px] border-2 border-dashed border-[#e5e7eb] rounded-xl bg-[#f9fafb] hover:bg-[#f3f4f6] hover:border-[#6a874c] transition-colors cursor-pointer overflow-hidden" id="photoLabel">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-[#9ca3af] group-hover:text-[#6a874c]" id="uploadPlaceholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <p class="text-[13px] font-medium mb-1">Upload foto kandidat</p>
                                <p class="text-[11px] text-[#6b7280]">PNG, JPG, JPEG (Maks. 2MB)</p>
                            </div>
                            <img id="photoPreview" class="absolute inset-0 w-full h-full object-cover hidden rounded-xl" alt="Preview Foto">
                        </label>
                        <input id="photo" name="photo" type="file" class="hidden" accept="image/*" onchange="previewPhoto(this)"/>
                    </div>
                    <button type="button" onclick="clearPhoto()" id="clearPhotoBtn" class="hidden mt-3 text-[12px] text-red-500 hover:text-red-700 font-medium">
                        Hapus Foto
                    </button>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="md:col-span-2 space-y-5">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama kandidat" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent">
                        </div>
                        
                        <!-- NIS -->
                        <div>
                            <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Nomor Induk Siswa (NIS) <span class="text-red-400">*</span></label>
                            <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Contoh: 230101001" class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Status -->
                        <div>
                            <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Status Keaktifan <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <select name="status" required class="appearance-none w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent cursor-pointer">
                                    <option value="aktif" {{ old('status') === 'aktif' || old('status') === null ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6b7280]">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Info Kelas -->
                        <div>
                            <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Kelas</label>
                            <input type="text" value="{{ Auth::user()->class?->class_name ?? 'Kelas Anda' }}" disabled readonly class="w-full px-4 py-2.5 bg-[#f9fafb] border border-[#e5e7eb] rounded-lg text-[13px] font-semibold text-[#6b7280] cursor-not-allowed">
                            <p class="text-[11px] text-[#9ca3af] mt-1">Kandidat otomatis masuk ke kelas Anda</p>
                        </div>
                    </div>

                    <!-- Visi -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Visi</label>
                        <textarea name="visi" rows="3" placeholder="Masukkan visi kandidat..." class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent resize-y">{{ old('visi') }}</textarea>
                    </div>

                    <!-- Misi -->
                    <div>
                        <label class="block text-[13px] font-bold text-[#1f2937] mb-2">Misi</label>
                        <textarea name="misi" rows="4" placeholder="Masukkan misi kandidat (gunakan daftar angka atau bullet untuk lebih rapi)..." class="w-full px-4 py-2.5 bg-white border border-[#e5e7eb] rounded-lg text-[13px] font-medium text-[#1f2937] placeholder-[#9ca3af] focus:outline-none focus:ring-2 focus:ring-[#6a874c] focus:border-transparent resize-y">{{ old('misi') }}</textarea>
                    </div>

                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 border-t border-[#f0f0f0] bg-[#fafbf8] flex items-center justify-end gap-3">
                <a href="{{ route('walikelas.candidates') }}" class="px-5 py-2 rounded-lg text-[13px] font-bold text-[#4b5563] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 rounded-lg text-[13px] font-bold text-white bg-[#6a874c] hover:bg-[#5a7440] transition-colors flex items-center gap-2 shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan Kandidat
                </button>
            </div>
            
        </form>
    </div>
@endsection

@section('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const clearBtn = document.getElementById('clearPhotoBtn');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            clearBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearPhoto() {
    const input = document.getElementById('photo');
    const preview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const clearBtn = document.getElementById('clearPhotoBtn');
    input.value = '';
    preview.src = '';
    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    clearBtn.classList.add('hidden');
}
</script>
@endsection
