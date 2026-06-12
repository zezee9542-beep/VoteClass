{{-- ===== PROFILE POPUP PANEL ===== --}}
{{-- Usage: @include('partials.profile-popup', ['updateRoute' => route('...profile.update'), 'roleLabel' => '...']) --}}

{{-- Dropdown Overlay (for closing when clicking outside) --}}
<div id="profileDropdownOverlay" onclick="closeProfileDropdown()" class="fixed inset-0 z-[50] bg-transparent hidden"></div>

{{-- Dropdown Panel --}}
<div id="profileDropdown" class="fixed top-[74px] right-4 z-[60] w-64 bg-white rounded-xl shadow-xl border border-[#e8e0c8]/60 overflow-hidden opacity-0 pointer-events-none translate-y-[-10px] transition-all duration-200">
    {{-- User Header Info (Soft Creamy Yellow/Green Blend) --}}
    <div class="p-4 flex items-center gap-3 border-b border-[#e8e0c8]/40" style="background: linear-gradient(135deg, #fbf6e1 0%, #f4ebd1 100%);">
        <div class="w-10 h-10 rounded-full overflow-hidden border border-[#e8e0c8] bg-white">
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=edf1e6&color=405834&bold=true' }}" class="w-full h-full object-cover">
        </div>
        <div class="overflow-hidden">
            <h4 class="text-[13px] font-bold text-[#2f3d20] truncate leading-tight">{{ Auth::user()->name }}</h4>
            <p class="text-[11px] font-semibold text-[#8c9c72] mt-0.5 truncate">{{ $roleLabel ?? 'Pengguna' }}</p>
        </div>
    </div>
    
    {{-- Menu Items --}}
    <div class="p-1.5 space-y-0.5">
        <button onclick="openProfileModal()" class="w-full flex items-center gap-2.5 px-3 py-2 text-[13px] font-bold text-[#485c3f] hover:bg-[#f3f7ef] rounded-lg transition-colors text-left">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Pengaturan Profil
        </button>
        <a href="/logout" class="flex items-center gap-2.5 px-3 py-2 text-[13px] font-bold text-[#8c524f] hover:bg-[#faf1f0] rounded-lg transition-colors text-left">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Keluar dari Akun
        </a>
    </div>
</div>

{{-- Modal Wrapper (Centering Backdrop and Modal Content) --}}
<div id="profileModalWrapper" class="fixed inset-0 z-[80] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="closeProfileModal()"></div>
    
    {{-- Modal Content --}}
    <div id="profileModal" class="bg-white rounded-2xl shadow-2xl border border-[#e8e0c8]/80 w-[450px] max-w-[calc(100vw-2rem)] overflow-hidden transform scale-95 transition-all duration-300 relative z-10">
        
        {{-- Header gradient banner (Soft Wavy Green & Creamy Yellow) --}}
        <div class="relative h-28 overflow-hidden flex items-end p-5" style="background: linear-gradient(135deg, #e2ebd9 0%, #fbf6e1 45%, #f4ebd1 100%); border-bottom: 1px solid rgba(232, 224, 200, 0.4);">
            {{-- Wavy effect layer --}}
            <div class="absolute inset-0 opacity-40 mix-blend-multiply" style="background-image: radial-gradient(circle at 70% -20%, #dcd6ba 0%, transparent 60%), radial-gradient(circle at 10% 120%, #c8d7b7 0%, transparent 50%);"></div>
            
            {{-- Close button --}}
            <button type="button" onclick="closeProfileModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/5 hover:bg-black/10 transition-all flex items-center justify-center text-[#2f3d20] focus:outline-none">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            <div class="flex items-center gap-4 relative z-10">
                {{-- Avatar --}}
                <div class="relative group cursor-pointer" onclick="document.getElementById('modalAvatarInput').click()">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white bg-white shadow-sm">
                        <img id="modalAvatarPreview"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=edf1e6&color=405834&bold=true&size=96' }}"
                            class="w-full h-full object-cover" alt="Avatar">
                    </div>
                    {{-- Edit overlay --}}
                    <div class="absolute inset-0 rounded-full bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-[16px] font-bold text-[#2f3d20] leading-tight" id="modalDisplayName">{{ Auth::user()->name }}</h3>
                    <p class="text-[11px] font-bold text-[#8c9c72] uppercase tracking-wider mt-0.5">{{ $roleLabel ?? 'Pengguna' }}</p>
                </div>
            </div>
        </div>

        {{-- Form body --}}
        <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="file" id="modalAvatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewModalAvatar(this)">
            <input type="hidden" name="remove_avatar" id="modalRemoveAvatarInput" value="0">

            {{-- Validation Alerts (Muted Soft Tones, No Neon) --}}
            @if(session('profile_success'))
                <div class="px-4 py-3 bg-[#f3f7ef] border border-[#e4ecde] rounded-xl flex items-center gap-2.5 text-[13px] font-semibold text-[#485c3f]">
                    <svg class="w-4.5 h-4.5 text-[#485c3f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('profile_success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="px-4 py-3 bg-[#fdf2f2] border border-[#fbe3e3] rounded-xl text-[13px] font-semibold text-[#8c524f] space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#8c524f] shrink-0"></span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Avatar Actions info --}}
            <div class="flex items-center justify-between bg-[#fafaf7] px-4 py-2.5 rounded-xl border border-[#e8e0c8]/40">
                <span class="text-[12px] font-bold text-[#6e7568]">Foto Profil</span>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="document.getElementById('modalAvatarInput').click()"
                        class="text-[11px] font-bold text-[#485c3f] bg-[#f3f7ef] border border-[#e4ecde] px-3 py-1.5 rounded-lg hover:bg-[#e4ecde] transition-colors">
                        Unggah Foto
                    </button>
                    <button type="button" onclick="removeModalAvatar()"
                        class="text-[11px] font-bold text-[#8c524f] bg-[#faf1f0] border border-[#eedad8] px-3 py-1.5 rounded-lg hover:bg-[#eedad8] transition-colors {{ Auth::user()->avatar ? '' : 'hidden' }}" id="modalRemoveAvatarBtn">
                        Hapus
                    </button>
                </div>
            </div>

            {{-- Inputs --}}
            <div class="space-y-3.5">
                <div>
                    <label class="block text-[11px] font-extrabold text-[#aab2a3] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full px-4 py-2.5 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-semibold text-[#2f3d20] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all">
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-[#aab2a3] uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                        class="w-full px-4 py-2.5 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-semibold text-[#2f3d20] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-extrabold text-[#aab2a3] uppercase tracking-wider mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="modalPassword"
                                class="w-full px-4 py-2.5 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-semibold text-[#2f3d20] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all pr-9"
                                placeholder="Kosongkan jika tidak diubah">
                            <button type="button" onclick="togglePasswordVis('modalPassword', 'eyeIconModal1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#aab2a3] hover:text-[#405834]">
                                <svg id="eyeIconModal1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-[#aab2a3] uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="modalPasswordConfirm"
                                class="w-full px-4 py-2.5 bg-[#fafaf7] border border-[#e8e0c8] rounded-xl text-[13px] font-semibold text-[#2f3d20] focus:outline-none focus:bg-white focus:border-[#8c9c72] focus:ring-1 focus:ring-[#8c9c72] transition-all pr-9"
                                placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePasswordVis('modalPasswordConfirm', 'eyeIconModal2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#aab2a3] hover:text-[#405834]">
                                <svg id="eyeIconModal2" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#f0ede4]">
                <button type="button" onclick="closeProfileModal()"
                    class="px-4 py-2.5 rounded-xl text-[13px] font-bold text-[#6e7568] bg-white border border-[#e8e0c8] hover:bg-[#fafaf7] transition-all">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-[#485c3f] hover:bg-[#394a32] text-white font-bold text-[13px] rounded-xl transition-all shadow-md flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Open/Close Dropdown
    function openProfilePopup() {
        const dropdown = document.getElementById('profileDropdown');
        const overlay = document.getElementById('profileDropdownOverlay');
        const isOpen = !dropdown.classList.contains('pointer-events-none');
        
        if (isOpen) {
            closeProfileDropdown();
        } else {
            dropdown.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
            dropdown.classList.add('opacity-100', 'translate-y-0');
            overlay.classList.remove('hidden');
        }
    }

    // Close Dropdown
    function closeProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const overlay = document.getElementById('profileDropdownOverlay');
        dropdown.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
        dropdown.classList.remove('opacity-100', 'translate-y-0');
        overlay.classList.add('hidden');
    }

    // Open Modal
    function openProfileModal() {
        closeProfileDropdown();
        
        const wrapper = document.getElementById('profileModalWrapper');
        const modal = document.getElementById('profileModal');
        
        wrapper.classList.remove('opacity-0', 'pointer-events-none');
        wrapper.classList.add('opacity-100');
        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'opacity-100');
    }

    // Close Modal
    function closeProfileModal() {
        const wrapper = document.getElementById('profileModalWrapper');
        const modal = document.getElementById('profileModal');
        
        modal.classList.remove('scale-100', 'opacity-100');
        modal.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            wrapper.classList.add('opacity-0', 'pointer-events-none');
            wrapper.classList.remove('opacity-100');
        }, 300);
    }

    // Avatar preview for modal
    function previewModalAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('modalAvatarPreview').src = e.target.result;
                const topbarAvatar = document.getElementById('topbarAvatarImg');
                if (topbarAvatar) topbarAvatar.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            document.getElementById('modalRemoveAvatarBtn').classList.remove('hidden');
            document.getElementById('modalRemoveAvatarInput').value = '0';
        }
    }

    // Remove avatar for modal
    function removeModalAvatar() {
        const defaultAvatar = 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=edf1e6&color=405834&bold=true&size=96';
        document.getElementById('modalAvatarPreview').src = defaultAvatar;
        const topbarAvatar = document.getElementById('topbarAvatarImg');
        if (topbarAvatar) topbarAvatar.src = defaultAvatar;
        document.getElementById('modalRemoveAvatarInput').value = '1';
        document.getElementById('modalRemoveAvatarBtn').classList.add('hidden');
        document.getElementById('modalAvatarInput').value = '';
    }

    // Toggle password visibility
    function togglePasswordVis(inputId, iconId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Auto-open modal if validation errors or success occurred
    @if($errors->any() || session('profile_success'))
        document.addEventListener('DOMContentLoaded', function() {
            openProfileModal();
        });
    @endif
</script>
{{-- ===== END PROFILE POPUP ===== --}}
