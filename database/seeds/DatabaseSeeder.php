<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Residency\Occupation;
use App\Models\Residency\Education;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\User;
use App\Models\Residency\BeneficiaryType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $educations = [
            "Tidak/Belum Sekolah",
            "Tidak Tamat SD/Sederajat",
            "Tamat SD/Sederajat",
            "SLTP/Sederajat",
            "SLTA/Sederajat",
            "Diploma I/II",
            "Akademi/Diploma III/S.Muda",
            "Diploma IV/Strata I",
            "Strata II",
            "Strata III",
        ];
        
        foreach ($educations as $e) {
            Education::create(['name' => $e]);
        }

        $occupations = [
            'Belum Bekerja',
            'Mengurus Rumah Tangga',
            'Pelajar / Mahasiswa',
            'Pensiunan',
            'Pegawai Negeri Sipil',
            'Tentara Nasional Indonesia',
            'Kepolisian RI',
            'Perdagangan',
            'Petani / Pekebun',
            'Peternak',
            'Nelayan / Perikanan',
            'Industri',
            'Konstruksi',
            'Transportasi',
            'Karyawan Swasta',
            'Karyawan BUMN',
            'Karyawan BUMD',
            'Karyawan Honorer',
            'Buruh Harian Lepas',
            'Buruh Tani / Perkebunan',
            'Buruh Nelayan / Perikanan',
            'Buruh Peternakan',
            'Pembantu Rumah Tangga',
            'Tukang Cukur',
            'Tukang Listrik',
            'Tukang Batu',
            'Tukang Kayu',
            'Tukang Sol Sepatu',
            'Tukang Las / Pandai Besi',
            'Tukang Jahit',
            'Penata Rambut',
            'Penata Rias',
            'Penata Busana',
            'Mekanik ',
            'Tukang Gigi ',
            'Seniman ',
            'Tabib',
            'Paraji',
            'Perancang Busana',
            'Penterjemah',
            'Imam Masjid',
            'Pendeta',
            'Pastur',
            'Wartawan',
            'Ustadz / Mubaligh',
            'Juru Masak',
            'Promotor Acara',
            'Anggota DPR-RI',
            'Anggota DPD',
            'Anggota BPK',
            'Presiden',
            'Wakil Presiden',
            'Anggota Mahkamah Konstitusi',
            'Anggota Kabinet / Kementerian',
            'Duta Besar',
            'Gubernur',
            'Wakil Gubernur',
            'Bupati',
            'Wakil Bupati',
            'Walikota',
            'Wakil Walikota',
            'Anggota DPRD Propinsi',
            'Anggota DPRD Kabupaten / Kota',
            'Dosen',
            'Guru',
            'Pilot',
            'Pengacara',
            'Notaris',
            'Arsitek',
            'Akuntan',
            'Konsultan',
            'Dokter',
            'Bidan',
            'Perawat',
            'Apoteker',
            'Psikiater / Psikolog',
            'Penyiar Televisi',
            'Penyiar Radio',
            'Pelaut',
            'Peneliti',
            'Sopir',
            'Pialang',
            'Paranormal',
            'Pedagang',
            'Perangkat Desa',
            'Kepala Desa',
            'Biarawati',
            'Wiraswasta',
        ];

        foreach($occupations as $o) {
            Occupation::create(['name' => $o]);
        }

        $permissions = [
            'Olah Data Kependudukan' => 'kependudukan',
            'Olah Data Keuangan' => 'keuangan',
            'Olah Data Surat' => 'surat',
            'Olah Data Pertanahan' => 'pertanahan',
            'Olah Data Pengguna' => 'pengguna',
            'Olah Data Masyarakat' => 'masyarakat',
        ];

        foreach ($permissions as $key => $value) {
            Permission::create([
                'name' => $key,
                'route_name' => $value,
            ]);
        }

        $role = Role::create([
            'name' => 'Admin'
        ]);

        $role->permissions()->sync([
            1, 2, 3, 4, 5, 6,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('rahasia'),
            'role_id' => 1,
        ]);

        $admin->role()->associate($role);

        // $certificateTypes = [
        //     "Surat Keterangan Pengantar",
        //     "Surat Keterangan Penduduk",
        //     "Surat Biodata Penduduk",
        //     "Surat Keterangan Pindah Penduduk",
        //     "Surat Keterangan Jual Beli",
        //     "Surat Pengantar SKCK",
        //     "Surat Keterangan KTP dalam proses",
        //     "Surat Keterangan Beda Identitas",
        //     "Surat Keterangan Bepergian/Jalan",
        //     "Surat Keterangan Kurang Mampu",
        //     "Surat Pengatar Izin Keramaian",
        //     "Surat Pengantar Laporan Kehilangan",
        //     "Surat Keterangan Usaha",
        //     "Surat Keterangan JAMKESOS",
        //     "Surat Keterangan Domisili Usaha",
        //     "Surat Keterangan Kelahiran",
        //     "Surat Permohonan Akta Lahir",
        //     "Surat Pernyataan Belum Memiliki Akta Lahir",
        //     "Surat Permohonan Duplikat Kelahiran",
        //     "Surat Keterangan Kematian",
        //     "Surat Keterangan Lahir Mati",
        //     "Surat Keterangan Untuk Nikah",
        //     "Surat Keterangan Pergi Kawin",
        //     "Surat Keterangan Wali Hakim",
        //     "Surat Permohonan Duplikat Surat Nikah",
        //     "Surat Cerai",
        //     "Surat Keterangan Pengantar Rujuk/Cerai",
        //     "Surat Permohonan Kartu Keluarga",
        //     "Surat Domisili Usaha Non-Warga",
        //     "Surat Keterangan Beda Identitas KIS",
        //     "Surat Keterangan Izin Orang Tua/Suami/Istri",
        //     "Surat Pernyataan Penguasaan Fisik Bidang Tanah (SPORADIK)",
        //     "Surat Permohonan Perubahan Kartu Keluarga",
        //     "Surat Keterangan Domisili",
        // ];

        // foreach ($certificateTypes as $t) {
        //     CertificateType::create([
        //         'name' => $t,
        //     ]);
        // }

        $beneficiaryTypes = [
            'Program Indonesia Pintar',
            'Bantuan Langsung Tunai',
            'Program Keluarga Harapan',
            'Bantuan Pangan Non Tunai',
        ];

        foreach ($beneficiaryTypes as $t) {
            BeneficiaryType::create([
                'name' => $t,
            ]);
        }
    }
}
