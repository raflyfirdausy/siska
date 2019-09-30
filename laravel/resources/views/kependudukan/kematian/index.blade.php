{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Kematian |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Kematian
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
              <a href="{{ url("kematian/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("kematian/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <a href="{{ url("kematian/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Mendiang</th>
              <th>Tanggal Kematian</th>
              <th>Waktu Kematian</th>
              <th>Tempat Kematian</th>
              <th>Detail</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($deaths as $d)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $d->resident->name }}</td>
              <td>{{ $d->date_of_death->format('d/m/Y') }}</td>
              <td>{{ $d->time_of_death }}</td>
              <td>{{ $d->tempatKematian }}</td>
              <td><button
                class="btn btn-primary show-button"
                data-kematian="{{ json_encode([
                  'cause_of_death' => $d->cause_of_death,
                  'determinant' => $d->penentuKematian, 
                  'reporter' => $d->reporter,
                  'reporter_relation' => $d->hubunganPelapor]) }}"
                data-toggle="modal" data-target="#modal-show">
                  Lihat
              </button></td>
              <td class="text-center">
                <div class="form-group">
                  <a href="{{ action('Residency\DeathController@edit', $d->id) }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                  <button type="button" class="btn btn-danger delete-button" data-mati='@json(['id' => $d->id, 'nama' => $d->resident->name ])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $deaths->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data kematian dari <span id="nama-penduduk">-</span>?
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
            <table class="table table-striped">
                <tr>
                  <th><strong>Penyebab</strong></th>
                  <td style="text-align: left">:&nbsp;<span id="cause_of_death">-</span></td>
                </tr>
                <tr>   
                  <th><strong>Penentu Kematian<strong></th>
                    <td style="text-align: left">:&nbsp;<span id="determinant">-</span></td>
                </tr>
                <tr>   
                  <th><strong>Pelapor<strong></th>
                    <td style="text-align: left">:&nbsp;<span id="reporter">-</span></td>
                </tr>
                <tr>   
                  <th><strong>Hubungan Pelapor<strong></th>
                    <td style="text-align: left">:&nbsp;<span id="reporter_relation">-</span></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $('.delete-button').on('click', function() {
      var mati = $(this).data('mati');
      var link =  '/kematian/' + mati.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(mati.nama);
    });

    $('.show-button').on('click', function() {
      var kematian = $(this).data('kematian');
      for (var key of Object.keys(kematian)) {
        $('#' + key).text(kematian[key]);
      }
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection