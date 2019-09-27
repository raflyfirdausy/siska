{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Pengguna |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Pengguna
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="pull-right">
          <a href="{{ url("pengguna/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th colspan="2" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($users as $u)
            <tr>
              <td>{{ $u->id }}</td>
              <td>{{ $u->name }}</td>
              <td>{{ $u->username }}</td>
              <td><a href="{{ url("role/".$u->role->id) }}">{{ $u->role->name }}</a></td>
              <td class="text-center">
                <div class="form-group">
                  <form action="{{ url("pengguna/$u->id/hapus") }}" class="form-inline" method="POST">
                    @csrf
                    <a href="{{ url("pengguna/$u->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
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