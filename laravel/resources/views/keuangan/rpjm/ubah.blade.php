{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah RPJM |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data RPJM {{ $rpjm->title }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\RPJMController@update", $rpjm->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan RPJM disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="title" name="title" required autocomplete="false" value="{{ $rpjm->title }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Tahun <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" id="year" name="year" required autocomplete="false" value="{{ $rpjm->year }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kategori </label>
                    <div class="col-md-12">
                      <select class="form-control" disabled>
                        <option>{{ ucfirst($rpjm->category) }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\RPJMController@index") }}" class="btn btn-default">Kembali</a>
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