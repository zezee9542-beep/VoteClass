<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\VotingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WaliKelasController extends Controller
{
    private function checkClass()
    {
        $classId = Auth::user()->class_id;
        if (!$classId) {
            abort(403, 'Anda belum ditugaskan ke kelas manapun.');
        }
        return $classId;
    }

    public function dashboard()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $belumVoting = $totalSiswa - $sudahVoting;

        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        $candidates = Candidate::where('class_id', $classId)->with('votingResult')->get();
        
        $results = [];
        foreach ($candidates as $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100) : 0;
            $results[] = [
                'name' => $c->name,
                'nis' => $c->nis,
                'votes' => $votes,
                'pct' => $candidatePct
            ];
        }

        return view('walikelas.dashboard', compact('class', 'totalSiswa', 'sudahVoting', 'belumVoting', 'pct', 'results', 'candidates'));
    }

    public function users(Request $request)
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $query = User::where('role', 'siswa')->where('class_id', $classId);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis_nip', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status voting
        $filterStatus = $request->input('status');
        $votedUserIds = Vote::where('class_id', $classId)->pluck('user_id')->toArray();
        if ($filterStatus === 'Sudah Voting') {
            $query->whereIn('id', $votedUserIds);
        } elseif ($filterStatus === 'Belum Voting') {
            $query->whereNotIn('id', $votedUserIds);
        }

        $users = $query->get();

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = count($votedUserIds);
        $belumVoting = $totalSiswa - $sudahVoting;

        $usersData = [];
        foreach ($users as $index => $u) {
            $usersData[] = [
                'no' => $index + 1,
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'nis' => $u->nis_nip,
                'kelas' => $class->class_name,
                'voted' => in_array($u->id, $votedUserIds)
            ];
        }

        return view('walikelas.users.index', [
            'users' => $usersData,
            'totalSiswa' => $totalSiswa,
            'sudahVoting' => $sudahVoting,
            'belumVoting' => $belumVoting,
            'class' => $class
        ]);
    }

    public function storeUser(Request $request)
    {
        $classId = $this->checkClass();

        $request->validate([
            'name' => 'required|string|max:255',
            'nis_nip' => 'required|string|unique:users,nis_nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'nis_nip' => $request->nis_nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'class_id' => $classId,
        ]);

        return redirect()->route('walikelas.users')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $classId = $this->checkClass();
        $user = User::where('class_id', $classId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis_nip' => 'required|string|unique:users,nis_nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->nis_nip = $request->nis_nip;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('walikelas.users')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $classId = $this->checkClass();
        $user = User::where('class_id', $classId)->findOrFail($id);
        $user->delete();

        return redirect()->route('walikelas.users')->with('success', 'Siswa berhasil dihapus.');
    }

    public function candidates(Request $request)
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $query = Candidate::where('class_id', $classId);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $candidates = $query->with('votingResult')->get();

        $totalKandidat = Candidate::where('class_id', $classId)->count();
        $aktifKandidat = Candidate::where('class_id', $classId)->where('status', 'aktif')->count();
        $nonaktifKandidat = $totalKandidat - $aktifKandidat;

        $sudahVoting = Vote::where('class_id', $classId)->count();

        $candidatesData = [];
        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $pct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100, 1) : 0;

            $candidatesData[] = [
                'no' => $index + 1,
                'id' => $c->id,
                'name' => $c->name,
                'nis' => $c->nis,
                'photo' => $c->photo,
                'visi' => $c->visi,
                'misi' => $c->misi,
                'status' => $c->status,
                'votes' => $votes,
                'pct' => $pct
            ];
        }

        return view('walikelas.candidates.index', [
            'candidates' => $candidatesData,
            'totalKandidat' => $totalKandidat,
            'aktifKandidat' => $aktifKandidat,
            'nonaktifKandidat' => $nonaktifKandidat,
            'class' => $class
        ]);
    }

    public function storeCandidate(Request $request)
    {
        $classId = $this->checkClass();

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'photo' => 'nullable|image|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates', 'public');
        }

        $candidate = Candidate::create([
            'class_id' => $classId,
            'name' => $request->name,
            'nis' => $request->nis,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'status' => $request->status,
            'photo' => $photoPath,
        ]);

        VotingResult::create([
            'candidate_id' => $candidate->id,
            'class_id' => $classId,
            'total_votes' => 0
        ]);

        return redirect()->route('walikelas.candidates')->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function updateCandidate(Request $request, $id)
    {
        $classId = $this->checkClass();
        $candidate = Candidate::where('class_id', $classId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates', 'public');
            $candidate->photo = $photoPath;
        }

        $candidate->name = $request->name;
        $candidate->nis = $request->nis;
        $candidate->visi = $request->visi;
        $candidate->misi = $request->misi;
        $candidate->status = $request->status;
        $candidate->save();

        return redirect()->route('walikelas.candidates')->with('success', 'Kandidat berhasil diperbarui.');
    }

    public function deleteCandidate($id)
    {
        $classId = $this->checkClass();
        $candidate = Candidate::where('class_id', $classId)->findOrFail($id);
        $candidate->delete();

        return redirect()->route('walikelas.candidates')->with('success', 'Kandidat berhasil dihapus.');
    }

    public function votes(Request $request)
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $query = Vote::where('class_id', $classId)->with('user');

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis_nip', 'like', '%' . $request->search . '%');
            });
        }

        $votes = $query->latest()->get();

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $belumVoting = $totalSiswa - $sudahVoting;
        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        return view('walikelas.votes.index', compact('votes', 'totalSiswa', 'sudahVoting', 'belumVoting', 'pct', 'class'));
    }

    public function exportVotes()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $votes = Vote::where('class_id', $classId)->with('user')->latest()->get();

        $csvRows = [];
        $csvRows[] = ['No', 'ID Log', 'Waktu Pemilihan', 'Nama Siswa', 'NIS', 'IP Address', 'Status'];

        foreach ($votes as $index => $v) {
            $csvRows[] = [
                $index + 1,
                '#VT-' . str_pad($v->id, 3, '0', STR_PAD_LEFT),
                $v->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB',
                $v->user ? $v->user->name : 'Tidak diketahui',
                $v->user ? $v->user->nis_nip : '-',
                $v->ip_address ?? '-',
                'Terverifikasi'
            ];
        }

        $filename = 'log-suara-' . $class->class_name . '-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($csvRows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            foreach ($csvRows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function votingResults()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        $candidates = Candidate::where('class_id', $classId)->with('votingResult')->get();

        $chartLabels = [];
        $chartSeries = [];
        $candidatesData = [];

        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100, 1) : 0;

            $chartLabels[] = $c->name;
            $chartSeries[] = $votes;

            $candidatesData[] = [
                'no_urut' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'name' => $c->name,
                'nis' => $c->nis,
                'votes' => $votes,
                'pct' => $candidatePct,
                'photo' => $c->photo
            ];
        }

        // Sort candidates by total votes desc for standings
        usort($candidatesData, function ($a, $b) {
            return $b['votes'] <=> $a['votes'];
        });

        return view('walikelas.voting_results.index', [
            'class' => $class,
            'totalSiswa' => $totalSiswa,
            'sudahVoting' => $sudahVoting,
            'belumVoting' => $totalSiswa - $sudahVoting,
            'pct' => $pct,
            'chartLabels' => $chartLabels,
            'chartSeries' => $chartSeries,
            'candidates' => $candidatesData
        ]);
    }

    // ===== Real-Time API Endpoints =====

    public function realtimeStats()
    {
        $classId = $this->checkClass();

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $belumVoting = $totalSiswa - $sudahVoting;
        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        $candidates = Candidate::where('class_id', $classId)->with('votingResult')->get();

        $chartLabels = [];
        $chartSeries = [];
        $candidatesData = [];

        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100, 1) : 0;
            $chartLabels[] = $c->name;
            $chartSeries[] = $votes;
            $candidatesData[] = [
                'name' => $c->name,
                'votes' => $votes,
                'pct' => $candidatePct,
                'photo' => $c->photo,
            ];
        }

        return response()->json([
            'totalSiswa' => $totalSiswa,
            'sudahVoting' => $sudahVoting,
            'belumVoting' => $belumVoting,
            'pct' => $pct,
            'chartLabels' => $chartLabels,
            'chartSeries' => $chartSeries,
            'candidates' => $candidatesData,
            'lastUpdated' => now()->timezone('Asia/Jakarta')->format('H:i:s'),
        ]);
    }

    public function exportResults()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        $candidates = Candidate::where('class_id', $classId)->with('votingResult')->get();
        $candidatesData = [];

        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100, 1) : 0;
            $candidatesData[] = [
                'no_urut' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'name' => $c->name,
                'nis' => $c->nis,
                'votes' => $votes,
                'pct' => $candidatePct,
            ];
        }
        usort($candidatesData, fn($a, $b) => $b['votes'] <=> $a['votes']);

        $csvRows = [];
        $csvRows[] = ['Laporan Hasil Pemilihan Ketua Kelas ' . $class->class_name];
        $csvRows[] = ['Tahun Ajaran: ' . $class->academic_year];
        $csvRows[] = ['Dicetak: ' . now()->timezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB'];
        $csvRows[] = [];
        $csvRows[] = ['No. Urut', 'Nama Kandidat', 'NIS', 'Total Suara', 'Persentase'];

        foreach ($candidatesData as $c) {
            $csvRows[] = [$c['no_urut'], $c['name'], $c['nis'], $c['votes'], $c['pct'] . '%'];
        }
        $csvRows[] = [];
        $csvRows[] = ['Total Partisipan: ' . $sudahVoting . ' / ' . $totalSiswa . ' (' . $pct . '%)'];

        $filename = 'hasil-pemilihan-' . $class->class_name . '-' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($csvRows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            foreach ($csvRows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->input('remove_avatar') == '1' && $user->avatar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('profile_success', 'Profil berhasil diperbarui.');
    }
}
