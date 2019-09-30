{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Role |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Role
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="pull-right">
          <a href="{{ url("role/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nama Role</th>
                  <th>Hak Akses</th>
                  <th colspan="2" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($roles as $r)
            <tr>
              <td>{{ $r->id }}</td>
              <td>{{ $r->name }}</td>
              <td>
              @foreach ($r->permissions as $p)
                  {{$p->name}}{{ !$loop->last ? ', ' : '' }}
              @endforeach
              </td>
              <td class="text-center">
                <div class="form-group">
                  <form action="{{ url("role/$r->id/hapus") }}" class="form-inline" method="POST">
                    @csrf
                    <a href="{{ url("role/$r->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
    
@endsection