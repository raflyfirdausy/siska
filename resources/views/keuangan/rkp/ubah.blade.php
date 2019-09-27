{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah RKP |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data RKP {{ $rkp->rpjm->title }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\RKPController@update", $rkp->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan RKP disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul RPJM Desa </label>
                    <div class="col-md-12">
                      <select name="rpjm_id" id="rpjm_id" class="form-control" title="Pilih salah satu">
                        <option></option>
                        @foreach($rpjm as $r)
                        <option value="{{ $r->id }}" {{ $rkp->rpjm->id == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kategori </label>
                    <div class="col-md-12">
                      <select name="category" id="category" disabled class="form-control" title="Pilih salah satu">
                        <option>{{ ucfirst($rkp->category) }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Deskripsi <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $rkp->description }}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Target <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="target" id="target" value="{{ $rkp->target }}">
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\RKPController@index") }}" class="btn btn-default">Kembali</a>
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