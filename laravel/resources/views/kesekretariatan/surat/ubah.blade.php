{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Surat {{ ucfirst($type) }} |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Surat {{ ucfirst($type) }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("surat-{$type}/{$mail->id}/ubah") }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan perbaharui data surat {{ $type }} disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-12 form-label">Tanggal Surat <span class="asterisk">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" name="date" type="date" required value="{{ $mail->date->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 form-label">Nomor Surat <span class="asterisk">*</span></label>
                    <div class="col-md-6">
                        <input class="form-control" name="number" type="text" required value="{{ $mail->number }}">
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">{{ $type == 'masuk' ? 'Pengirim' : 'Tujuan' }} <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <input type="text" name="target" id="target" class="form-control" value="{{ $mail->target }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Isi Singkat Surat <span class="asterisk">*</span></label>
                  <div class="col-md-8">
                    <input type="text" name="summary" id="summary" class="form-control" value="{{ $mail->summary }}">
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 form-label">Keterangan <span class="asterisk">*</span></label>
                    <div class="col-md-10">
                        <textarea class="form-control" row="20" name="note" required>{{ $mail->note }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 form-label">Rekomendasi<span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="recommendation" required>
                        <option {{ $mail->recommendation == 'kepala_desa' ? 'selected' : '' }} value="kepala_desa">Kepala Desa</option>
                        <option {{ $mail->recommendation == 'sekretaris' ? 'selected' : '' }} value="sekretaris">Sekretaris</option>
                        <option {{ $mail->recommendation == 'bpd' ? 'selected' : '' }} value="bpd">BPD</option>
                        <option {{ $mail->recommendation == 'kaur_pemerintah' ? 'selected' : '' }} value="kaur_pemerintah">Kaur Pemerintahan</option>
                        <option {{ $mail->recommendation == 'kaur_pembangunan' ? 'selected' : '' }} value="kaur_pembangunan">Kaur Pembangunan</option>
                        <option {{ $mail->recommendation == 'kaur_kesejahteraan' ? 'selected' : '' }} value="kaur_kesejahteraan">Kaur Kesejahteraan</option>
                        <option {{ $mail->recommendation == 'kaur_keuangan' ? 'selected' : '' }} value="kaur_keuangan">Kaur Keuangan</option>
                        <option {{ $mail->recommendation == 'kaur_umum' ? 'selected' : '' }} value="kaur_umum">Kaur Umum</option>
                      </select>
                    </div>
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
