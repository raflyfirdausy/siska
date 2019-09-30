{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Sumber Anggaran |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Sumber Anggaran {{ $source->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\BudgetSourceController@update", $source->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan sumber anggaran disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nama Anggaran <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="name" name="name" required autocomplete="false" value="{{ $source->name }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jumlah Anggaran (Rupiah) <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" id="budget" name="budget" required autocomplete="false" value="{{ $source->budget }}">
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\BudgetSourceController@index") }}" class="btn btn-default">Kembali</a>
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