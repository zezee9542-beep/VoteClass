@extends('siswa.layouts.app')

@section('title', 'Berikan Suara')
@section('page-title', 'Berikan Suara')
@section('page-subtitle', 'Gunakan hak pilih Anda dengan bijak')

@section('content')

    @if(session('voted_successfully'))
        <!-- Success Screen -->
        <div id="successSection" class="max-w-md mx-auto text-center py-16">
            <div class="w-20 h-20 rounded-full bg-[#edf5e6] border-2 border-[#d6e8c3] text-[#6a874c] flex items-center justify-center mx-auto mb-6 animate-bounce">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h2 class="text-[#2f3d20] font-extrabold text-[22px] tracking-tight mb-2">Terima Kasih atas Pilihan Anda!</h2>
            <p class="text-[#6e7568] text-[14px] leading-relaxed mb-8">Pilihan suara Anda berhasil dicatat dan diverifikasi oleh sistem. Semoga ketua kelas terpilih dapat membawa kemajuan bagi kelas {{ $class->class_name }}!</p>
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 bg-[#6a874c] hover:bg-[#5a7440] text-white text-[13px] font-bold px-6 py-3 rounded-lg hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
                Kembali ke Dashboard
            </a>
        </div>
    @else
        <!-- Ballot Container -->
        <div id="ballotSection" class="max-w-4xl mx-auto text-center py-6">
            <h2 class="text-[#2f3d20] font-extrabold text-[24px] tracking-tight mb-2">SURAT SUARA ELEKTRONIK</h2>
            <p class="text-[#8c9c72] text-[13px] font-bold uppercase tracking-wider mb-8">Pemilihan Ketua Kelas {{ $class->class_name }} Periode {{ $class->academic_year }}</p>

            <!-- Candidate Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-left">
                @forelse($candidates as $index => $c)
                <!-- Candidate Card -->
                <button onclick="selectCandidate('{{ $c->id }}', '{{ $c->name }}', '{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}')" class="bg-white border-2 border-[#e8e0c8] rounded-2xl p-6 text-left hover:border-[#6a874c] hover:shadow-md transition-all duration-300 w-full group relative focus:outline-none flex flex-col justify-between min-h-[360px]">
                    <div>
                        <!-- No Urut Big Bubble -->
                        <div class="w-12 h-12 rounded-xl bg-[#edf5e6] text-[#405834] flex items-center justify-center font-extrabold text-[20px] mb-6 border border-[#d6e8c3] group-hover:bg-[#6a874c] group-hover:text-white transition-colors">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <!-- Photo -->
                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-[#d6e8c3] mx-auto mb-6 bg-[#edf5e6]">
                            @if($c->photo)
                                <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c->name) }}&background=edf5e6&color=405834&size=96&bold=true" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <!-- Name & NIS -->
                        <h3 class="text-[16px] font-bold text-[#2f3d20] text-center mb-1 leading-tight">{{ $c->name }}</h3>
                        <p class="text-[12px] text-[#9ca3af] text-center mb-4">NIS: {{ $c->nis }}</p>
                    </div>
                    <!-- Selection Indicator -->
                    <div class="w-full bg-[#fdf9ef] border border-[#e8e0c8] py-2 rounded-xl text-[#405834] text-center text-[12px] font-bold group-hover:bg-[#6a874c] group-hover:text-white group-hover:border-transparent transition-all">
                        Pilih Kandidat
                    </div>
                </button>
                @empty
                <div class="md:col-span-3 py-12 text-center text-[#9ca3af]">
                    <p class="font-medium text-[15px]">Belum ada kandidat aktif saat ini.</p>
                </div>
                @endforelse
            </div>

            <p class="text-[#aab2a3] text-[12px] font-medium">Suara Anda dijamin anonim & aman dengan sistem enkripsi kami.</p>
        </div>

        <!-- Hidden Form for Vote Submission -->
        <form id="voteForm" action="{{ route('siswa.submit-vote') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="candidate_id" id="formCandidateId">
        </form>

        <!-- Confirm Vote Modal -->
        <div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeModal()"></div>
            
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl w-full max-w-md p-6 relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="confirmModalContent">
                <h3 class="text-[17px] font-bold text-[#1f2937] text-center mb-4">Konfirmasi Pilihan Anda</h3>
                
                <div class="bg-[#fdf9ef] border border-[#e8e0c8] rounded-xl p-4 text-center mb-6">
                    <p class="text-[12px] text-[#6e7568] mb-1">Anda akan memilih kandidat:</p>
                    <p id="selectedName" class="text-[16px] font-extrabold text-[#405834]"></p>
                    <p id="selectedNo" class="text-[11px] font-bold text-[#d5b263] mt-0.5"></p>
                </div>

                <p class="text-[11px] text-[#ef4444] text-center font-semibold mb-6">⚠️ Pilihan ini tidak dapat diubah kembali setelah dikonfirmasi.</p>

                <div class="flex items-center justify-center gap-3">
                    <button onclick="closeModal()" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-[#4b5563] bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] hover:-translate-y-0.5 transition-all duration-300 flex-1">
                        Batal
                    </button>
                    <button onclick="submitVote()" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-white bg-[#6a874c] hover:bg-[#5a7440] shadow-sm hover:-translate-y-0.5 transition-all duration-300 flex-1">
                        Ya, Konfirmasi!
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('scripts')
<script>
    let chosenId = '';
    let chosenNo = '';
    let chosenName = '';

    function selectCandidate(id, name, no) {
        chosenId = id;
        chosenNo = no;
        chosenName = name;

        document.getElementById('selectedName').textContent = name;
        document.getElementById('selectedNo').textContent = 'Kandidat Nomor Urut ' + no;

        const modal = document.getElementById('confirmModal');
        const content = document.getElementById('confirmModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        const content = document.getElementById('confirmModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 300);
    }

    function submitVote() {
        closeModal();
        document.getElementById('formCandidateId').value = chosenId;
        document.getElementById('voteForm').submit();
    }
</script>
@endsection
