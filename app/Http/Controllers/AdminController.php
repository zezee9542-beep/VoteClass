<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\VotingResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClasses = ClassModel::count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        
        // Voting Aktif: Kelas yang memiliki kandidat aktif
        $votingAktif = ClassModel::whereHas('candidates', function($q) {
            $q->where('status', 'aktif');
        })->count();

        // Status Voting per Kelas
        $classesList = ClassModel::all();
        $classStatuses = [];
        foreach ($classesList as $cls) {
            $wali = User::where('role', 'walikelas')->where('class_id', $cls->id)->first();
            $siswaCount = User::where('role', 'siswa')->where('class_id', $cls->id)->count();
            $suaraCount = Vote::where('class_id', $cls->id)->count();
            
            $pct = $siswaCount > 0 ? round(($suaraCount / $siswaCount) * 100) : 0;
            
            $status = 'belum';
            if ($suaraCount > 0) {
                $status = ($suaraCount >= $siswaCount) ? 'selesai' : 'berlangsung';
            }

            $classStatuses[] = [
                'id' => $cls->id,
                'name' => $cls->class_name,
                'wali' => $wali ? $wali->name : 'Belum ditugaskan',
                'siswa' => $siswaCount,
                'suara' => $suaraCount,
                'pct' => $pct,
                'status' => $status
            ];
        }

        // Wali Kelas Terdaftar
        $waliList = User::where('role', 'walikelas')->with('class')->get();
        $waliStatuses = [];
        foreach ($waliList as $wali) {
            $siswaCount = $wali->class_id ? User::where('role', 'siswa')->where('class_id', $wali->class_id)->count() : 0;
            $suaraCount = $wali->class_id ? Vote::where('class_id', $wali->class_id)->count() : 0;
            
            $status = 'belum';
            if ($suaraCount > 0) {
                $status = ($suaraCount >= $siswaCount) ? 'selesai' : 'berlangsung';
            }

            $waliStatuses[] = [
                'name' => $wali->name,
                'kelas' => $wali->class ? $wali->class->class_name : null,
                'siswa' => $siswaCount,
                'status' => $status
            ];
        }

        return view('admin.dashboard', compact('totalClasses', 'totalWaliKelas', 'totalSiswa', 'votingAktif', 'classStatuses', 'waliStatuses'));
    }

    public function classes(Request $request)
    {
        $query = ClassModel::query();
        if ($request->filled('search')) {
            $query->where('class_name', 'like', '%' . $request->search . '%');
        }
        $classes = $query->get();

        $classesData = [];
        foreach ($classes as $cls) {
            $wali = User::where('role', 'walikelas')->where('class_id', $cls->id)->first();
            $siswaCount = User::where('role', 'siswa')->where('class_id', $cls->id)->count();
            
            $tingkat = 'Kelas ' . preg_replace('/[^0-9]/', '', $cls->class_name);
            if (empty(preg_replace('/[^0-9]/', '', $cls->class_name))) {
                $tingkat = 'Umum';
            }

            $classesData[] = [
                'id' => $cls->id,
                'name' => $cls->class_name,
                'academic_year' => $cls->academic_year,
                'tingkat' => $tingkat,
                'wali' => $wali ? $wali->name : null,
                'siswa' => $siswaCount
            ];
        }

        return view('admin.classes.index', ['classes' => $classesData]);
    }

    public function storeClass(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:50',
            'academic_year' => 'nullable|string|max:20',
        ]);

        ClassModel::create([
            'class_name' => $request->class_name,
            'academic_year' => $request->academic_year ?? '2024/2025',
        ]);

        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function updateClass(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string|max:50',
            'academic_year' => 'nullable|string|max:20',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update([
            'class_name' => $request->class_name,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function deleteClass($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes')->with('success', 'Kelas berhasil dihapus.');
    }

    public function walikelas(Request $request)
    {
        $query = User::where('role', 'walikelas');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nis_nip', 'like', '%' . $request->search . '%');
        }
        $walikelas = $query->with('class')->get();
        $classes = ClassModel::all();

        return view('admin.walikelas.index', compact('walikelas', 'classes'));
    }

    public function storeWaliKelas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis_nip' => 'required|string|unique:users,nis_nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'class_id' => 'nullable|exists:classes,id',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->filled('class_id')) {
            User::where('class_id', $request->class_id)->where('role', 'walikelas')->update(['class_id' => null]);
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        User::create([
            'name' => $request->name,
            'nis_nip' => $request->nis_nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'walikelas',
            'class_id' => $request->class_id,
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('admin.walikelas')->with('success', 'Wali Kelas berhasil ditambahkan.');
    }

    public function updateWaliKelas(Request $request, $id)
    {
        $wali = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis_nip' => 'required|string|unique:users,nis_nip,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'class_id' => 'nullable|exists:classes,id',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->filled('class_id') && $request->class_id != $wali->class_id) {
            User::where('class_id', $request->class_id)->where('role', 'walikelas')->update(['class_id' => null]);
        }

        if ($request->hasFile('avatar')) {
            if ($wali->avatar) Storage::disk('public')->delete($wali->avatar);
            $wali->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $wali->name = $request->name;
        $wali->nis_nip = $request->nis_nip;
        $wali->email = $request->email;
        $wali->class_id = $request->class_id;

        if ($request->filled('password')) {
            $wali->password = Hash::make($request->password);
        }

        $wali->save();

        return redirect()->route('admin.walikelas')->with('success', 'Wali Kelas berhasil diperbarui.');
    }

    public function deleteWaliKelas($id)
    {
        $wali = User::findOrFail($id);
        $wali->delete();

        return redirect()->route('admin.walikelas')->with('success', 'Wali Kelas berhasil dihapus.');
    }

    public function votingOverview(Request $request)
    {
        $classes = ClassModel::all();
        $overview = [];

        foreach ($classes as $cls) {
            $wali = User::where('role', 'walikelas')->where('class_id', $cls->id)->first();
            $siswaCount = User::where('role', 'siswa')->where('class_id', $cls->id)->count();
            $suaraCount = Vote::where('class_id', $cls->id)->count();
            
            $pemenang = '-';
            $maxVotes = -1;
            $winnerCandidate = null;
            
            $results = VotingResult::where('class_id', $cls->id)->with('candidate')->get();
            foreach ($results as $res) {
                if ($res->total_votes > $maxVotes) {
                    $maxVotes = $res->total_votes;
                    $winnerCandidate = $res->candidate;
                }
            }

            if ($winnerCandidate && $suaraCount > 0) {
                $pct = round(($maxVotes / $suaraCount) * 100);
                $pemenang = $winnerCandidate->name . " ($pct%)";
            }

            $status = 'belum';
            if ($suaraCount > 0) {
                $status = ($suaraCount >= $siswaCount) ? 'selesai' : 'berlangsung';
            }

            $overview[] = [
                'kelas' => $cls->class_name,
                'wali' => $wali ? $wali->name : 'Belum ditugaskan',
                'status' => $status,
                'suara' => $suaraCount,
                'total' => $siswaCount,
                'pemenang' => $pemenang
            ];
        }

        return view('admin.voting_overview.index', compact('overview'));
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
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->input('remove_avatar') == '1' && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
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
