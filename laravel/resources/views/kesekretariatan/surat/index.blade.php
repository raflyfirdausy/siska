{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Surat {{ ucfirst($type) }} |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Surat {{ ucfirst($type) }}
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
            <a href="{{ url("surat-{$type}/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Foto</th>
                  <th>Tanggal Surat</th>
                  <th>Nomor Surat {{ $type }}</th>
                  <th>{{ $type == 'masuk' ? 'Pengirim' : 'Tujuan' }}</th>
                  <th>Isi Singkat</th>
                  <th>Rekomendasi</th>
                  <th colspan="3" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($mails as $m)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <button
                  class="btn btn-info show-photo-button"
                  data-toggle="modal"
                  data-target="#modal-show-photo"
                  data-url="{{ $m->photo ? asset($m->photo) : '' }}"
                >
                  Lihat
                </button>
              </td>
              <td>{{ $m->date->format('d/m/Y') }}</td>
              <td>{{ $m->number }}</td>
              <td>{{ $m->target }}</td>
              <td>{{ $m->summary }}</td>
              <td>{{ $m->rekomendasi }}</td>
              <td>
                <button class="btn btn-info show-button" data-toggle="modal" data-target="#modal-show" data-mail='@json($m)'>Lihat</button>
              </td>
              <td>
                <a href="{{ url("surat-{$type}/{$m->id}/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
              </td>
              <td>
                <button type="button" class="btn btn-danger delete-button" data-id="{{ $m->id }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $mails->appends($_GET)->links() }}
      </div>
    </div>
  </div>
  </div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <div class="modal fade" id="modal-show-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Foto</h4>
        </div>
        <div class="modal-body">
          <img id="mail-photo" src="-" class="img-responsive">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus surat {{ $type }} ini?
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
  <div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Keterangan</h4>
        </div>
        <div class="modal-body">
          <ul>
            <li><h4>Tanggal Surat :<h4> </li>
            <li id="date">-</li>
            <li><h4>Nomor Surat :<h4> </li>
            <li id="number">-</li>
            <li><h4>{{ $type == 'masuk' ? 'Pengirim' : 'Tujuan' }} :</h4></li>
            <li id="target">-</li>
            <li><h4>Isi Singkat :<h4> </li>
            <li id="summary">-</li>
            <li><h4>Keterangan :<h4> </li>
            <li id="note">-</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $('.delete-button').on('click', function() {
      var id = $(this).data('id');
      var link =  '/surat-{{$type}}/' + id + '/hapus';

      $('#form-delete').attr('action', link);
    });

    $('.show-photo-button').on('click', function() {
      var url = $(this).data('url');

      $('#mail-photo').attr('src', url);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });

    $('.show-button').on('click', function() {
      var mail = $(this).data('mail');
      $('#date').text(mail.date);
      $('#number').text(mail.number);
      $('#target').text(mail.target);
      $('#summary').text(mail.summary);
      $('#note').text(mail.note);
    });
  </script>
@endsection