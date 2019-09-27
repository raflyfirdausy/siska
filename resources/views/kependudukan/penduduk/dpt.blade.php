{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Daftar Pemilih Tetap |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Pemilih Tetap
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
            <div class="col-md-6" style="padding-left: 0;">
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                  <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <button type="submit" class="btn btn-primary">Cari</button>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-6">
            <div class="pull-right">
              <a href="{{ url("penduduk/daftar-pemilih-tetap/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("penduduk/daftar-pemilih-tetap/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>#</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>TTL</th>
                  <th>Umur</th>
                  <th>Pendidikan</th>
                  <th>Pekerjaan</th>
                  <th colspan="2" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($residents as $r)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $r->nik }}</td>
              <td>{{ $r->name }}</td>
              <td>{{ $r->jenkel }}</td>
              <td>{{ $r->birth_place }}, {{ $r->birthday->format('d/m/Y') }}</td>
              <td>{{ $r->birthday->age }}</td>
              <td>{{ $r->education->name }}</td>
              <td>{{ $r->occupation->name }}</td>
              <td class="text-center">
                <a href="{{ url("penduduk/$r->nik") }}" class="btn btn-info" style="margin-bottom:0px;">Lihat</a>
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