{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
Tambah Surat {{ ucfirst($type) }} |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')

@endsection

{{-- Judul halaman --}}
@section('page-title')
<strong>Tambah</strong> Surat {{ ucfirst($type) }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("surat-{$type}/tambah") }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan menambahkan data surat {{ $type }} baru disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Foto Surat </label>
                  <div class="col-md-12">
                    <input type="file" class="form-control" name="photo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Tanggal Surat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input class="form-control" name="date" type="date" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor Surat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input class="form-control" name="number" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">{{ $type == 'masuk' ? 'Pengirim' : 'Tujuan' }} <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" name="target" id="target" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Isi Singkat Surat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" name="summary" id="summary" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Keterangan </label>
                  <div class="col-md-12">
                    <textarea class="form-control" row="20" name="note"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Rekomendasi <span class="asterisk">*</span></label>
                  <select class="col-md-12" name="recommendation" required>
                    <option value="kepala_desa">Kepala Desa</option>
                    <option value="sekretaris">Sekretaris</option>
                    <option value="bpd">BPD</option>
                    <option value="kaur_pemerintah">Kaur Pemerintahan</option>
                    <option value="kaur_pembangunan">Kaur Pembangunan</option>
                    <option value="kaur_kesejahteraan">Kaur Kesejahteraan</option>
                    <option value="kaur_keuangan">Kaur Keuangan</option>
                    <option value="kaur_umum">Kaur Umum</option>
                  </select>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("surat-{$type}") }}" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
@endsection