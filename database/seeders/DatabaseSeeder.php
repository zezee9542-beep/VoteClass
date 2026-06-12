<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================
        // 1. Buat data Kelas (Classes)
        // ============================
        $classId = DB::table('classes')->insertGetId([
            'class_name' => 'XII RPL',
            'academic_year' => '2024/2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================
        // 2. Buat Akun Users
        // ============================

        // --- ADMIN ---
        User::create([
            'name'     => 'Administrator',
            'nis_nip'  => '198501012010011001',
            'email'    => 'admin@vooting.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'class_id' => null,
        ]);

        // --- WALI KELAS ---
        User::create([
            'name'     => 'Budi Santoso, S.Pd',
            'nis_nip'  => '197803152005011002',
            'email'    => 'budi.santoso@vooting.com',
            'password' => Hash::make('walikelas123'),
            'role'     => 'walikelas',
            'class_id' => $classId,
        ]);

        // --- 45 SISWA (RPL) ---
        $indonesianNames = [
            'Aditya Pratama', 'Bella Safira', 'Cahya Dewi', 'Dimas Arya', 'Eka Putri',
            'Farhan Rizky', 'Gita Nuraini', 'Hendra Saputra', 'Indah Permata', 'Joko Widodo',
            'Kartika Sari', 'Luthfi Hakim', 'Maya Anggraeni', 'Naufal Hidayat', 'Olivia Putri',
            'Putra Ramadhan', 'Qory Sandrina', 'Reza Mahendra', 'Salsabila Nur', 'Taufik Hidayat',
            'Umar Faruq', 'Vina Panduwinata', 'Wahyu Hidayat', 'Xena Altaris', 'Yusuf Mansur',
            'Zahra Amelia', 'Agung Laksono', 'Bagas Kara', 'Citra Lestari', 'Dedi Corbuzier',
            'Elsa Frozen', 'Fajar Sadboy', 'Gilang Dirga', 'Hesti Purwadinata', 'Irfan Hakim',
            'Julia Perez', 'Kevin Sanjaya', 'Lesti Kejora', 'Maudy Ayunda', 'Nadiem Makarim',
            'Olla Ramlan', 'Prabowo Subianto', 'Qomarudin', 'Raffi Ahmad', 'Sule Prikitiew'
        ];

        for ($i = 1; $i <= 45; $i++) {
            $name = $indonesianNames[$i - 1] ?? "Siswa RPL " . $i;
            $emailName = strtolower(str_replace(' ', '.', $name));
            User::create([
                'name'     => $name,
                'nis_nip'  => '2024' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'email'    => $emailName . '@siswa.vooting.com',
                'password' => Hash::make('siswa123'),
                'role'     => 'siswa',
                'class_id' => $classId,
            ]);
        }

        // ============================
        // 3. Buat Kandidat (Candidates)
        // ============================
        $candidates = [
            [
                'class_id' => $classId,
                'name' => 'Aditya Pratama',
                'nis' => '2024001',
                'visi' => 'Mewujudkan kelas XII RPL yang berprestasi, inovatif, dan berjiwa kolaboratif di bidang teknologi.',
                'misi' => "1. Menyelenggarakan coding session mingguan untuk saling membantu dalam praktikum.\n2. Memfasilitasi kolaborasi proyek tim untuk meningkatkan portofolio siswa.\n3. Menjadi jembatan komunikasi yang transparan antara siswa dan wali kelas.",
                'status' => 'aktif'
            ],
            [
                'class_id' => $classId,
                'name' => 'Bella Safira',
                'nis' => '2024002',
                'visi' => 'Mewujudkan kelas XII RPL yang solid, kreatif, dan suportif demi kenyamanan belajar bersama.',
                'misi' => "1. Menumbuhkan rasa kekeluargaan dan toleransi antar sesama teman sekelas.\n2. Mengadakan sesi sharing session seputar UI/UX dan perkembangan teknologi web terbaru.\n3. Meningkatkan kedisiplinan serta kepedulian terhadap fasilitas laboratorium komputer.",
                'status' => 'aktif'
            ],
            [
                'class_id' => $classId,
                'name' => 'Cahya Dewi',
                'nis' => '2024003',
                'visi' => 'Membangun kelas XII RPL yang kompetitif, berkarakter, dan aktif dalam kegiatan sekolah.',
                'misi' => "1. Mengoptimalkan potensi akademik kelas melalui kelompok belajar terarah.\n2. Mendukung teman-teman untuk aktif berpartisipasi dalam lomba kompetensi siswa (LKS) maupun hackathon.\n3. Mengelola kas kelas dengan amanah untuk kebutuhan mendesak siswa.",
                'status' => 'aktif'
            ],
        ];

        foreach ($candidates as $candidate) {
            $candidateId = DB::table('candidates')->insertGetId(array_merge($candidate, [
                'photo'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // ============================
            // 4. Inisialisasi Voting Results
            // ============================
            DB::table('voting_results')->insert([
                'candidate_id' => $candidateId,
                'class_id'     => $classId,
                'total_votes'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
