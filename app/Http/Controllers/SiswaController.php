<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\VotingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    private function checkClass()
    {
        $classId = Auth::user()->class_id;
        if (!$classId) {
            abort(403, 'Anda belum memiliki kelas. Hubungi Admin.');
        }
        return $classId;
    }

    public function dashboard()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $totalCandidates = Candidate::where('class_id', $classId)->where('status', 'aktif')->count();
        $votingStatus = Vote::where('class_id', $classId)->where('user_id', Auth::id())->exists();
        
        $candidates = Candidate::where('class_id', $classId)->where('status', 'aktif')->get();
        $sudahVotingCount = Vote::where('class_id', $classId)->count();

        // Calculate Hasil Sementara
        $standings = [];
        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $pct = $sudahVotingCount > 0 ? round(($votes / $sudahVotingCount) * 100) : 0;
            $standings[] = [
                'name' => $c->name,
                'votes' => $votes,
                'pct' => $pct
            ];
        }
        // Sort standings by votes desc
        usort($standings, function($a, $b) {
            return $b['votes'] <=> $a['votes'];
        });

        // Assign ranks (1, 2, 3)
        $rankedStandings = [];
        foreach ($standings as $i => $s) {
            $rankedStandings[] = [
                'name' => $s['name'],
                'votes' => $s['votes'],
                'pct' => $s['pct'],
                'rank' => $i + 1
            ];
        }

        return view('siswa.dashboard', compact('class', 'totalCandidates', 'votingStatus', 'candidates', 'rankedStandings'));
    }

    public function candidates()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);
        $candidates = Candidate::where('class_id', $classId)->where('status', 'aktif')->get();

        return view('siswa.candidates.index', compact('class', 'candidates'));
    }

    public function vote()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        // Check if student has already voted
        $alreadyVoted = Vote::where('class_id', $classId)->where('user_id', Auth::id())->exists();
        if ($alreadyVoted && !session('voted_successfully')) {
            return redirect()->route('siswa.dashboard')->with('info', 'Anda sudah menggunakan hak pilih Anda.');
        }

        $candidates = Candidate::where('class_id', $classId)->where('status', 'aktif')->get();

        return view('siswa.vote.index', compact('class', 'candidates'));
    }

    public function submitVote(Request $request)
    {
        $classId = $this->checkClass();

        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Verify candidate belongs to student's class and is active
        $candidate = Candidate::where('class_id', $classId)->where('status', 'aktif')->findOrFail($request->candidate_id);

        // Check if student already voted
        $alreadyVoted = Vote::where('class_id', $classId)->where('user_id', Auth::id())->exists();
        if ($alreadyVoted) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah memberikan suara sebelumnya.');
        }

        // Store Vote
        Vote::create([
            'user_id' => Auth::id(),
            'class_id' => $classId,
            'ip_address' => $request->ip(),
        ]);

        // Increment Candidate total_votes in voting_results
        $result = VotingResult::firstOrCreate(
            ['candidate_id' => $candidate->id, 'class_id' => $classId],
            ['total_votes' => 0]
        );
        $result->increment('total_votes');

        return redirect()->route('siswa.vote')->with('voted_successfully', true);
    }

    public function results()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $sudahVoting = Vote::where('class_id', $classId)->count();
        $belumVoting = $totalSiswa - $sudahVoting;
        $pct = $totalSiswa > 0 ? round(($sudahVoting / $totalSiswa) * 100) : 0;

        $candidates = Candidate::where('class_id', $classId)->where('status', 'aktif')->get();
        
        $standings = [];
        foreach ($candidates as $index => $c) {
            $votes = $c->votingResult ? $c->votingResult->total_votes : 0;
            $candidatePct = $sudahVoting > 0 ? round(($votes / $sudahVoting) * 100) : 0;
            $standings[] = [
                'name' => $c->name,
                'no' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'votes' => $votes,
                'pct' => $candidatePct,
                'photo' => $c->photo
            ];
        }

        // Sort standings by votes desc
        usort($standings, function($a, $b) {
            return $b['votes'] <=> $a['votes'];
        });

        // Add rank
        foreach ($standings as $i => &$s) {
            $s['rank'] = $i + 1;
        }

        // Get Wali Kelas name
        $wali = User::where('role', 'walikelas')->where('class_id', $classId)->first();

        return view('siswa.results.index', [
            'class' => $class,
            'totalSiswa' => $totalSiswa,
            'sudahVoting' => $sudahVoting,
            'belumVoting' => $belumVoting,
            'pct' => $pct,
            'standings' => $standings,
            'waliName' => $wali ? $wali->name : 'Wali Kelas'
        ]);
    }

    public function profile()
    {
        $classId = $this->checkClass();
        $class = ClassModel::find($classId);
        $wali = User::where('role', 'walikelas')->where('class_id', $classId)->first();
        $voted = Vote::where('class_id', $classId)->where('user_id', Auth::id())->exists();

        return view('siswa.profile.index', compact('class', 'wali', 'voted'));
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
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('profile_success', 'Profil berhasil diperbarui.');
    }
}
