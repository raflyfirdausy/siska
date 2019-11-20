<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@login');
Route::post('/', 'HomeController@processLogin');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'HomeController@login');
    Route::post('/login', 'HomeController@processLogin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    Route::get('/dashboard', 'HomeController@index');
    Route::get('/logout', 'HomeController@logout');
});

Route::middleware(['auth', 'access:pengguna'])->group(function () {
    Route::get('/pengguna', 'User\UserController@index');
    Route::get('/pengguna/tambah', 'User\UserController@create');
    Route::post('/pengguna/tambah', 'User\UserController@store');
    Route::get('/pengguna/{id}/ubah', 'User\UserController@edit');
    Route::post('/pengguna/{id}/ubah', 'User\UserController@update');
    
    Route::get('/role', 'User\RoleController@index');
    Route::get('/role/tambah', 'User\RoleController@create');
    Route::post('/role/tambah', 'User\RoleController@store');
    Route::get('/role/{id}', 'User\RoleController@show');
    Route::get('/role/{id}/ubah', 'User\RoleController@edit');
    Route::post('/role/{id}/ubah', 'User\RoleController@update');
    Route::post('/role/{id}/hapus', 'User\RoleController@destroy');

    Route::get('perangkat-desa', 'General\OfficialController@index');
    Route::post('perangkat-desa/tambah', 'General\OfficialController@store');
    Route::post('perangkat-desa/{id}/ubah', 'General\OfficialController@update');
    Route::post('perangkat-desa/{id}/hapus', 'General\OfficialController@destroy');

    Route::get('pengaturan', 'General\OptionController@index');
    Route::get('pengaturan/ubah', 'General\OptionController@edit');
    Route::post('pengaturan/ubah', 'General\OptionController@update');
});

Route::middleware(['auth', 'access:kependudukan'])->group(function () {

    //START =================================================================================

    Route::get('/modul-kependudukan', 'ModulKependudukanController@modulKependudukan');
    Route::post('/modul-kependudukan', 'ModulKependudukanController@modulKependudukan');
    Route::get('/modul-kependudukan/detail/{nik}', 'ModulKependudukanController@modulKependudukanDetail');
    Route::get('/modul-kependudukan/detail', function () {
        return redirect('/modul-kependudukan');
    });

    Route::get('/modul-kependudukan/cetak-ket-pengantar/{nik}', 'ModulKependudukanController@print_keterangan_pengantar');
    Route::get('/modul-kependudukan/cetak-keterangan-data-hilang', 'ModulKependudukanController@print_keterangan_data_hilang');
    Route::get('/modul-kependudukan/cetak-ket-usaha/{nik}', 'ModulKependudukanController@print_keterangan_usaha');
    Route::get('/modul-kependudukan/cetak-ket-tanah/{nik}', 'ModulKependudukanController@print_keterangan_tanah');
    Route::get('/modul-kependudukan/cetak-ket-kematian/{nik}', 'ModulKependudukanController@print_keterangan_kematian');
    Route::get('/modul-kependudukan/cetak-ket-domisili/{nik}', 'ModulKependudukanController@print_keterangan_domisili');
    Route::get('/modul-kependudukan/cetak-ket-domisili-lembaga/{nik}', 'ModulKependudukanController@print_keterangan_domisili_lembaga');
    Route::get('/modul-kependudukan/cetak-ket-tidak-mampu/{nik}', 'ModulKependudukanController@print_keterangan_tidak_mampu');
    Route::get('/modul-kependudukan/cetak-ket-beda-nama-identitas/{nik}', 'ModulKependudukanController@print_keterangan_beda_nama_identitas');

    Route::get('/penduduk/statistik', 'ModulKependudukanController@statistikKependudukan');
    Route::get('/penduduk/statistik/export', 'ModulKependudukanController@exportStatistikKependudukan');
    
    Route::get('/cek-no-surat', 'ModulKependudukanController@cekNoSurat');
    Route::get('/get-no-surat-terakhir', 'ModulKependudukanController@cekNoSuratTerakhir');
    Route::get('/cek-no-surat-lengkap', 'SuratController@cekKodeSuratLengkap');

    Route::get('/surat-keluar', 'SuratController@getSuratKeluar');
    Route::post('/tambah-surat-keluar', 'SuratController@addSuratKeluarManual');
    Route::post('/edit-surat-keluar', 'SuratController@editSuratKeluar');
    Route::post('/hapus-surat-keluar', 'SuratController@hapusSuratKeluar');
    Route::get('/download-surat-keluar', 'SuratController@downloadSuratKeluar');

    //END=================================================================




    Route::get('/keluarga', 'Residency\FamilyController@index');
    Route::get('/keluarga/tambah', 'Residency\FamilyController@create');
    Route::post('/keluarga/tambah', 'Residency\FamilyController@store');
    Route::get('/keluarga/export', 'Residency\FamilyController@export');
    Route::get('/keluarga/cetak', 'Residency\FamilyController@print');
    Route::get('/keluarga/{no_kk}/tambah-anggota', 'Residency\FamilyController@createMember');
    Route::post('/keluarga/{no_kk}/tambah-anggota', 'Residency\FamilyController@storeMember');
    Route::get('/keluarga/{no_kk}', 'Residency\FamilyController@show');
    Route::get('/keluarga/{no_kk}/ubah', 'Residency\FamilyController@edit');
    Route::post('/keluarga/{no_kk}/ubah', 'Residency\FamilyController@update');
    Route::post('/keluarga/{no_kk}/hapus', 'Residency\FamilyController@destroy');
    Route::get('/keluarga/{no_kk}/anggota', 'Residency\FamilyController@getFamilyMembers');
    Route::get('/keluarga/{no_kk}/kepala', 'Residency\FamilyController@getFamily');
    
    Route::get('/penduduk', 'Residency\ResidentController@index');
    Route::get('/penduduk/cetak', 'Residency\ResidentController@print');
    // Route::get('/penduduk/statistik', 'Residency\ResidentController@statistics');
    Route::get('/penduduk/daftar-pemilih-tetap', 'Residency\ResidentController@dpt');
    Route::get('/penduduk/daftar-pemilih-tetap/cetak', 'Residency\ResidentController@printDpt');
    Route::get('/penduduk/daftar-pemilih-tetap/export', 'Residency\ResidentController@exportDpt');
    Route::get('/penduduk/export', 'Residency\ResidentController@export');
    Route::get('/penduduk/{nik}', 'Residency\ResidentController@show');
    Route::get('/penduduk/{nik}/ubah', 'Residency\ResidentController@edit');
    Route::post('/penduduk/{nik}/ubah', 'Residency\ResidentController@update');
    Route::post('/penduduk/{nik}/hapus', 'Residency\ResidentController@destroy');
    Route::get('/penduduk/{nik}/info', 'Residency\ResidentController@getResident');

    Route::get('/penduduk/{nik}/cetak-bio-penduduk', 'Residency\ResidentController@printbiopddk');
    Route::get('/penduduk/{nik}/cetak-ket-pengantar', 'Residency\ResidentController@printKetPngtr');
    Route::get('/penduduk/{nik}/cetak-ket-domisili', 'Residency\ResidentController@printKetDomisili');
    Route::get('/penduduk/{nik}/cetak-skck', 'Residency\ResidentController@printSKCK');
    Route::get('/penduduk/{nik}/cetak-sktm', 'Residency\ResidentController@printSKTM');
    Route::get('/penduduk/{nik}/cetak-ket-kehilangan', 'Residency\ResidentController@printKehilangan');
    Route::get('/penduduk/{nik}/cetak-izin-keramaian', 'Residency\ResidentController@printKeramaian');
    Route::get('/penduduk/{nik}/cetak-ket-usaha', 'Residency\ResidentController@printUsaha');
    Route::get('/penduduk/{nik}/cetak-ket-penduduk', 'Residency\ResidentController@printketPddk');
    Route::get('/penduduk/{nik}/cetak-ket-ktp-proses', 'Residency\ResidentController@printKtpProses');
    Route::get('/penduduk/{nik}/cetak-sporadik', 'Residency\ResidentController@printSporadik');
    Route::get('/penduduk/{nik}/cetak-perdupnikah', 'Residency\ResidentController@printPerdupNikah');
    Route::get('/penduduk/{nik}/cetak-per-akta', 'Residency\ResidentController@printAkta');
    Route::get('/penduduk/{nik}/cetak-per-cerai', 'Residency\ResidentController@printCerai');
    Route::get('/penduduk/{nik}/cetak-per-dup-kelahiran', 'Residency\ResidentController@printPerDupKelahiran');
    Route::get('/penduduk/{nik}/cetak-perkk', 'Residency\ResidentController@printPerKK');
    Route::get('/penduduk/{nik}/cetak-perpkk', 'Residency\ResidentController@printPerPKK');
    Route::get('/penduduk/{nik}/cetak-pernyataan-akta', 'Residency\ResidentController@printPerAkta');

    Route::get('/pendatang', 'Residency\NewcomerController@index');
    Route::get('/pendatang/tambah', 'Residency\NewcomerController@create');
    Route::get('/pendatang/cetak', 'Residency\NewcomerController@print');
    Route::get('/pendatang/export', 'Residency\NewcomerController@export');
    Route::post('/pendatang/tambah', 'Residency\NewcomerController@store');
    Route::get('/pendatang/{id}/ubah', 'Residency\NewcomerController@edit');
    Route::post('/pendatang/{id}/ubah', 'Residency\NewcomerController@update');
    Route::post('/pendatang/{id}/hapus', 'Residency\NewcomerController@destroy');
    
    Route::get('/kepindahan', 'Residency\TransferController@index');
    Route::get('/kepindahan/tambah', 'Residency\TransferController@create');
    Route::post('/kepindahan/tambah', 'Residency\TransferController@store');
    Route::post('/kepindahan/{id}/hapus', 'Residency\TransferController@destroy');
    Route::get('/kepindahan/{id}/ubah', 'Residency\TransferController@edit');
    Route::post('/kepindahan/{id}/ubah', 'Residency\TransferController@update');
    Route::get('/kepindahan/export', 'Residency\TransferController@export');
    Route::get('/kepindahan/cetak', 'Residency\TransferController@print');
    
    Route::get('/migrasi', 'Residency\LaborMigrationController@index');
    Route::get('/migrasi/tambah', 'Residency\LaborMigrationController@create');
    Route::post('/migrasi/tambah', 'Residency\LaborMigrationController@store');
    Route::get('/migrasi/{id}/ubah', 'Residency\LaborMigrationController@edit');
    Route::post('/migrasi/{id}/ubah', 'Residency\LaborMigrationController@update');
    Route::post('/migrasi/{id}/hapus', 'Residency\LaborMigrationController@destroy');
    Route::get('/migrasi/cetak', 'Residency\LaborMigrationController@print');
    Route::get('/migrasi/export', 'Residency\LaborMigrationController@export');

    Route::get('/kematian', 'Residency\DeathController@index');
    Route::get('/kematian/tambah', 'Residency\DeathController@create');
    Route::post('/kematian/store', 'Residency\DeathController@store');
    Route::get('/kematian/{id}/ubah', 'Residency\DeathController@edit');
    Route::post('/kematian/{id}/ubah', 'Residency\DeathController@update');
    Route::post('/kematian/{id}/hapus', 'Residency\DeathController@destroy');
    Route::get('/kematian/cetak', 'Residency\DeathController@print');
    Route::get('/kematian/export', 'Residency\DeathController@export');

    Route::get('/kelahiran', 'Residency\BirthController@index');
    Route::get('/kelahiran/tambah', 'Residency\BirthController@create');
    Route::post('/kelahiran/tambah', 'Residency\BirthController@store');
    Route::get('/kelahiran/{id}/ubah', 'Residency\BirthController@edit');
    Route::post('/kelahiran/{id}/ubah', 'Residency\BirthController@update');
    Route::post('/kelahiran/{id}/hapus', 'Residency\BirthController@destroy');
    Route::get('/kelahiran/cetak', 'Residency\BirthController@print');
    Route::get('/kelahiran/export', 'Residency\BirthController@export');

    Route::get('/kemiskinan', 'Residency\PovertyController@index');
    Route::get('/kemiskinan/cetak', 'Residency\PovertyController@print');
    Route::post('/kemiskinan/tambah', 'Residency\PovertyController@store');
    Route::post('/kemiskinan/{id}/hapus', 'Residency\PovertyController@destroy');
    Route::get('/kemiskinan/export', 'Residency\PovertyController@export');
    Route::get('/kemiskinan/cetak', 'Residency\PovertyController@print');
    
    Route::get('/audit-kemiskinan', 'Residency\PovertyAuditController@index');
    Route::get('/audit-kemiskinan/tambah', 'Residency\PovertyAuditController@create');
    Route::get('/audit-kemiskinan/cetak', 'Residency\PovertyAuditController@print');
    Route::get('/audit-kemiskinan/export', 'Residency\PovertyAuditController@export');
    Route::post('/audit-kemiskinan/tambah', 'Residency\PovertyAuditController@store');
    Route::post('/audit-kemiskinan/{id}/hapus', 'Residency\PovertyAuditController@destroy');

    Route::get('/penerima-bantuan', 'Residency\BeneficiaryController@index');
    Route::get('/penerima-bantuan/tambah', 'Residency\BeneficiaryController@create');
    Route::get('/penerima-bantuan/cetak', 'Residency\BeneficiaryController@print');
    Route::get('/penerima-bantuan/export', 'Residency\BeneficiaryController@export');
    Route::post('/penerima-bantuan/tambah', 'Residency\BeneficiaryController@store');
    Route::get('/penerima-bantuan/{id}/ubah', 'Residency\BeneficiaryController@edit');
    Route::post('/penerima-bantuan/{id}/ubah', 'Residency\BeneficiaryController@update');
    Route::post('/penerima-bantuan/{id}/hapus', 'Residency\BeneficiaryController@destroy');

    Route::get('/jenis-bantuan', 'Residency\BeneficiaryTypeController@index');
    Route::get('/jenis-bantuan/tambah', 'Residency\BeneficiaryTypeController@create');
    Route::post('/jenis-bantuan/tambah', 'Residency\BeneficiaryTypeController@store');
    Route::get('/jenis-bantuan/{id}/ubah', 'Residency\BeneficiaryTypeController@edit');
    Route::post('/jenis-bantuan/{id}/ubah', 'Residency\BeneficiaryTypeController@update');
    Route::post('/jenis-bantuan/{id}/hapus', 'Residency\BeneficiaryTypeController@destroy');
});

Route::middleware(['auth', 'access:surat'])->group(function() {
    Route::get('/surat-masuk', 'Secretariat\InboxController@index');
    Route::get('/surat-masuk/tambah', 'Secretariat\InboxController@create');
    Route::post('/surat-masuk/tambah', 'Secretariat\InboxController@store');
    Route::get('/surat-masuk/{id}/ubah', 'Secretariat\InboxController@edit');
    Route::post('/surat-masuk/{id}/ubah', 'Secretariat\InboxController@update');
    Route::post('/surat-masuk/{id}/hapus', 'Secretariat\InboxController@destroy');

    // Route::get('/surat-keluar', 'Secretariat\OutboxController@index');
    Route::get('/surat-keluar/tambah', 'Secretariat\OutboxController@create');
    Route::post('/surat-keluar/tambah', 'Secretariat\OutboxController@store');
    Route::get('/surat-keluar/{id}/ubah', 'Secretariat\OutboxController@edit');
    Route::post('/surat-keluar/{id}/ubah', 'Secretariat\OutboxController@update');
    Route::post('/surat-keluar/{id}/hapus', 'Secretariat\OutboxController@destroy');

    Route::get('/laporan-masuk', 'Secretariat\CommentController@index');
    Route::get('/laporan-masuk/{id}/ubah', 'Secretariat\CommentController@update');
    
    Route::get('/getUsers', 'Secretariat\CommentController@getUsers');

    Route::post('/updateUser', 'Secretariat\CommentController@updateUser');
    
    Route::get('/pendaftaran', 'Secretariat\ServiceController@index');
    Route::get('/pendaftaran/{id}/hapus', 'Secretariat\ServiceController@destroy');
    Route::post('/pendaftaran/tambah', 'Secretariat\ServiceController@store');
    Route::get('/contoh', 'Secretariat\ServiceController@contoh');
});

Route::middleware(['auth', 'access:pertanahan'])->group(function() {
    Route::get('/blok-tanah', 'Estate\LandBlockController@index');
    Route::get('/blok-tanah/tambah', 'Estate\LandBlockController@create');
    Route::get('/blok-tanah/cetak', 'Estate\LandBlockController@print');
    Route::get('/blok-tanah/export', 'Estate\LandBlockController@export');
    Route::post('/blok-tanah/tambah', 'Estate\LandBlockController@store');
    Route::get('/blok-tanah/{id}/ubah', 'Estate\LandBlockController@edit');
    Route::post('/blok-tanah/{id}/ubah', 'Estate\LandBlockController@update');
    Route::post('/blok-tanah/{id}/hapus', 'Estate\LandBlockController@destroy');

    Route::get('/sertifikat-tanah', 'Estate\LandCertificateController@index');
    Route::get('/sertifikat-tanah/tambah', 'Estate\LandCertificateController@create');
    Route::get('/sertifikat-tanah/cetak', 'Estate\LandCertificateController@print');
    Route::get('/sertifikat-tanah/export', 'Estate\LandCertificateController@export');
    Route::post('/sertifikat-tanah/tambah', 'Estate\LandCertificateController@store');
    Route::get('/sertifikat-tanah/{id}', 'Estate\LandCertificateController@show');
    Route::get('/sertifikat-tanah/{id}/ubah', 'Estate\LandCertificateController@edit');
    Route::post('/sertifikat-tanah/{id}/ubah', 'Estate\LandCertificateController@update');
    Route::post('/sertifikat-tanah/{id}/hapus', 'Estate\LandCertificateController@destroy');

    Route::get('/kelas-tanah', 'Estate\LandClassController@index');
    Route::get('/kelas-tanah/tambah', 'Estate\LandClassController@create');
    Route::get('/kelas-tanah/cetak', 'Estate\LandClassController@print');
    Route::get('/kelas-tanah/export', 'Estate\LandClassController@export');
    Route::post('/kelas-tanah/tambah', 'Estate\LandClassController@store');
    Route::get('/kelas-tanah/{id}/ubah', 'Estate\LandClassController@edit');
    Route::post('/kelas-tanah/{id}/ubah', 'Estate\LandClassController@update');
    Route::post('/kelas-tanah/{id}/hapus', 'Estate\LandClassController@destroy');
});

Route::middleware(['auth', 'access:keuangan'])->group(function() {
    Route::get('/rpjm', 'Finance\RPJMController@index');
    Route::get('/rpjm/{title}/info', 'Finance\RPJMController@getRpjm');
    Route::get('/rpjm/tambah', 'Finance\RPJMController@create');
    Route::post('/rpjm/tambah', 'Finance\RPJMController@store');
    Route::get('/rpjm/{id}/ubah', 'Finance\RPJMController@edit');
    Route::post('/rpjm/{id}/ubah', 'Finance\RPJMController@update');
    Route::post('/rpjm/{id}/hapus', 'Finance\RPJMController@delete');

    Route::get('/rkp', 'Finance\RKPController@index');
    Route::get('/rkp/tambah', 'Finance\RKPController@create');
    Route::post('/rkp/tambah', 'Finance\RKPController@store');
    Route::get('/rkp/{id}/ubah', 'Finance\RKPController@edit');
    Route::post('/rkp/{id}/ubah', 'Finance\RKPController@update');
    Route::post('/rkp/{id}/hapus', 'Finance\RKPController@delete');

    Route::get('/apbd', 'Finance\APBDController@index');
    Route::get('/apbd/tambah', 'Finance\APBDController@create');
    Route::post('/apbd/tambah', 'Finance\APBDController@store');
    Route::get('/apbd/{id}/ubah', 'Finance\APBDController@edit');
    Route::post('/apbd/{id}/ubah', 'Finance\APBDController@update');
    Route::post('/apbd/{id}/hapus', 'Finance\APBDController@delete');

    Route::get('/pelaksanaan', 'Finance\ExecutionController@index');
    Route::get('/pelaksanaan/tambah', 'Finance\ExecutionController@create');
    Route::post('/pelaksanaan/tambah', 'Finance\ExecutionController@store');
    Route::get('/pelaksanaan/{id}/ubah', 'Finance\ExecutionController@edit');
    Route::post('/pelaksanaan/{id}/ubah', 'Finance\ExecutionController@update');
    Route::post('/pelaksanaan/{id}/hapus', 'Finance\ExecutionController@delete');

    Route::get('/usaha-desa', 'Finance\VillageBusinessController@index');
    Route::get('/usaha-desa/tambah', 'Finance\VillageBusinessController@create');
    Route::post('/usaha-desa/tambah', 'Finance\VillageBusinessController@store');
    Route::get('/usaha-desa/{id}/ubah', 'Finance\VillageBusinessController@edit');
    Route::post('/usaha-desa/{id}/ubah', 'Finance\VillageBusinessController@update');
    Route::post('/usaha-desa/{id}/hapus', 'Finance\VillageBusinessController@destroy');
    Route::get('/usaha-desa/{name}/info', 'Finance\VillageBusinessController@getBusiness');
    
    Route::get('/sumber-anggaran', 'Finance\BudgetSourceController@index');
    Route::get('/sumber-anggaran/tambah', 'Finance\BudgetSourceController@create');
    Route::post('/sumber-anggaran/tambah', 'Finance\BudgetSourceController@store');
    Route::get('/sumber-anggaran/{id}/ubah', 'Finance\BudgetSourceController@edit');
    Route::post('/sumber-anggaran/{id}/ubah', 'Finance\BudgetSourceController@update');
    Route::post('/sumber-anggaran/{id}/hapus', 'Finance\BudgetSourceController@destroy');
    Route::get('/sumber-anggaran/{name}/info', 'Finance\BudgetSourceController@getSource');
});



Route::get('/wilayah/provinsi', 'TerritoryController@getProvinces');
Route::get('/wilayah/{id}/sub', 'TerritoryController@getTerritories');
Route::get('/wilayah/{id}/village', 'TerritoryController@getVillages');

Route::get('/format-import/kependudukan', 'General\ImportFormatController@residentsFormat');
Route::get('/format-import/kelahiran', 'General\ImportFormatController@birthsFormat');
Route::get('/format-import/kematian', 'General\ImportFormatController@deathsFormat');
Route::get('/format-import/kepindahan', 'General\ImportFormatController@transfersFormat');
Route::get('/format-import/pendatang', 'General\ImportFormatController@newcomersFormat');
Route::get('/format-import/migrasi-tki', 'General\ImportFormatController@laborMigrationsFormat');
Route::get('/format-import/kemiskinan', 'General\ImportFormatController@povertiesFormat');
Route::get('/format-import/penerima-bantuan', 'General\ImportFormatController@beneficiariesFormat');
Route::get('/format-import/blok-tanah', 'General\ImportFormatController@landBlocksFormat');
Route::get('/format-import/kelas-tanah', 'General\ImportFormatController@landClassesFormat');
Route::get('/format-import/sertifikat-tanah', 'General\ImportFormatController@landCertificatesFormat');

// Route::get('/modul-kependudukan', 'Residency\ResidentController@modulKependudukan');
    // Route::post('/modul-kependudukan', 'Residency\ResidentController@modulKependudukan');
    // Route::get('/modul-kependudukan/detail/{nik}', 'Residency\ResidentController@modulKependudukanDetail');
    // Route::get('/modul-kependudukan/detail', function () {
    //     return redirect('/modul-kependudukan');
    // });

    // Route::get('/modul-kependudukan/cetak-ket-pengantar/{nik}', 'Residency\ResidentController@print_keterangan_pengantar');
    // Route::get('/modul-kependudukan/cetak-keterangan-data-hilang', 'Residency\ResidentController@print_keterangan_data_hilang');

    // Route::get('/penduduk/statistik', 'Residency\ResidentController@statistikKependudukan');
    // Route::get('/penduduk/statistik/export', 'Residency\ResidentController@exportStatistikKependudukan');