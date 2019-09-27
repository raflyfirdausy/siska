{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Role |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Role
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url('/role/tambah') }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <p>Silahkan isi data role baru disini</p>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Role <span class="asterisk">*</span></label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="role_name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Hak Akses <span class="asterisk">*</span></label>
                  @foreach ($permissions as $p)
                  <div class="col-md-12">
                      <label>
                          <input type="checkbox" name="permission_ids[]" value="{{$p->id}}"> {{ $p->name }}
                      </label>
                  </div>
                  @endforeach
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("role") }}" class="btn btn-default">Kembali</a>
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