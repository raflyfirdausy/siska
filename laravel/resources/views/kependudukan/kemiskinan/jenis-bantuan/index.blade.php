{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Jenis Bantuan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Daftar</strong> Jenis Bantuan
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
            <a href="{{ url("jenis-bantuan/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
          </div>
        </div>
      </div>
      <table id="posts-table" class="table table-tools table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($types as $t)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $t->name }}</td>
        <td class="text-center">
          <div class="form-group">
            <a href="{{ url("jenis-bantuan/$t->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0"> Ubah</a>
            <button type="submit" class="btn btn-danger delete-button" data-id="{{ $t->id }}" data-nama="{{ $t->name }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
          </div>
        </td>
        <td></td>
        </tr>
        @endforeach
      </tbody>
      </table>
      
    </div>
    <div class="pull-right">
      {{ $types->appends($_GET)->links() }}
    </div>
    </div>
  </div>
  </div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus data jenis bantuan <span id="nama">-</span>?
        </div>
        <div class="modal-footer">
          <form action="#" method="POST" id="form-delete">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            @csrf
            <button type="submit" class="btn btn-danger" id="delete-confirm">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.delete-button').on('click', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var link =  '/jenis-bantuan/' + id + '/hapus';

        $('#nama').text(nama);

        $('#form-delete').attr('action', link);
      });

      $('#delete-confirm').on('click', function() {
        $('#modal-confirm').modal('hide');
      });
    });
  </script>
@endsection