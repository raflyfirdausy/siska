{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Pengguna |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Pengguna
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url('pengguna/tambah') }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    @if ($errors->any())
      <p>ada</p>
      @foreach ($errors->all() as $a)
          <p>{{$a}}</p>
      @endforeach
    @endif
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <p>Silahkan isi data pengguna baru disini</p>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Pengguna <span class="asterisk">*</span></label>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Username <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="username" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Password <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <input type="password" class="form-control" name="password" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Konfirmasi Password <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <input type="password" class="form-control" name="password_confirmation" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Hak Akses <span class="asterisk">*</span></label>
                  <div class="col-md-4">
                    <select class="form-control" title="Pilih salah satu" name="role_id" required>
                        <option></option>
                        @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("pengguna") }}" class="btn btn-default">Kembali</a>
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