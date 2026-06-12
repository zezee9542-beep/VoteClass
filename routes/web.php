<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'walikelas') {
            return redirect()->route('walikelas.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi yang Anda masukkan salah.',
    ])->onlyInput('email');
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Admin Routes (Operator Sekolah)
Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::get('/classes', [App\Http\Controllers\AdminController::class, 'classes'])->name('admin.classes');
    Route::post('/classes', [App\Http\Controllers\AdminController::class, 'storeClass'])->name('admin.classes.store');
    Route::post('/classes/{id}/update', [App\Http\Controllers\AdminController::class, 'updateClass'])->name('admin.classes.update');
    Route::post('/classes/{id}/delete', [App\Http\Controllers\AdminController::class, 'deleteClass'])->name('admin.classes.delete');
    
    Route::get('/walikelas', [App\Http\Controllers\AdminController::class, 'walikelas'])->name('admin.walikelas');
    Route::post('/walikelas', [App\Http\Controllers\AdminController::class, 'storeWaliKelas'])->name('admin.walikelas.store');
    Route::post('/walikelas/{id}/update', [App\Http\Controllers\AdminController::class, 'updateWaliKelas'])->name('admin.walikelas.update');
    Route::post('/walikelas/{id}/delete', [App\Http\Controllers\AdminController::class, 'deleteWaliKelas'])->name('admin.walikelas.delete');
    
    Route::get('/voting-overview', [App\Http\Controllers\AdminController::class, 'votingOverview'])->name('admin.voting-overview');

    // Profile
    Route::post('/profile/update', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

// Wali Kelas Routes
Route::prefix('walikelas')->middleware('role:walikelas')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\WaliKelasController::class, 'dashboard'])->name('walikelas.dashboard');
    
    Route::get('/users', [App\Http\Controllers\WaliKelasController::class, 'users'])->name('walikelas.users');
    Route::post('/users', [App\Http\Controllers\WaliKelasController::class, 'storeUser'])->name('walikelas.users.store');
    Route::post('/users/{id}/update', [App\Http\Controllers\WaliKelasController::class, 'updateUser'])->name('walikelas.users.update');
    Route::post('/users/{id}/delete', [App\Http\Controllers\WaliKelasController::class, 'deleteUser'])->name('walikelas.users.delete');
    
    Route::get('/candidates', [App\Http\Controllers\WaliKelasController::class, 'candidates'])->name('walikelas.candidates');
    Route::post('/candidates', [App\Http\Controllers\WaliKelasController::class, 'storeCandidate'])->name('walikelas.candidates.store');
    Route::post('/candidates/{id}/update', [App\Http\Controllers\WaliKelasController::class, 'updateCandidate'])->name('walikelas.candidates.update');
    Route::post('/candidates/{id}/delete', [App\Http\Controllers\WaliKelasController::class, 'deleteCandidate'])->name('walikelas.candidates.delete');
    
    Route::get('/votes', [App\Http\Controllers\WaliKelasController::class, 'votes'])->name('walikelas.votes');
    Route::get('/votes/export', [App\Http\Controllers\WaliKelasController::class, 'exportVotes'])->name('walikelas.votes.export');

    Route::get('/voting-results', [App\Http\Controllers\WaliKelasController::class, 'votingResults'])->name('walikelas.voting-results');
    Route::get('/voting-results/export', [App\Http\Controllers\WaliKelasController::class, 'exportResults'])->name('walikelas.voting-results.export');

    // Real-time API (JSON polling)
    Route::get('/api/realtime-stats', [App\Http\Controllers\WaliKelasController::class, 'realtimeStats'])->name('walikelas.api.realtime-stats');

    // Profile
    Route::post('/profile/update', [App\Http\Controllers\WaliKelasController::class, 'updateProfile'])->name('walikelas.profile.update');
});

// Siswa Routes
Route::prefix('siswa')->middleware('role:siswa')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/candidates', [App\Http\Controllers\SiswaController::class, 'candidates'])->name('siswa.candidates');
    Route::get('/vote', [App\Http\Controllers\SiswaController::class, 'vote'])->name('siswa.vote');
    Route::post('/vote', [App\Http\Controllers\SiswaController::class, 'submitVote'])->name('siswa.submit-vote');
    Route::get('/results', [App\Http\Controllers\SiswaController::class, 'results'])->name('siswa.results');
    Route::get('/profile', [App\Http\Controllers\SiswaController::class, 'profile'])->name('siswa.profile');

    // Profile
    Route::post('/profile/update', [App\Http\Controllers\SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
});


