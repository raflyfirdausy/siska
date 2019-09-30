{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Kepindahan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Kepindahan
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
              <a href="{{ url("kepindahan/export") }}" class="btn btn-primary"><i class="fa fa-print"></i> Export</a>
              <a href="{{ url("kepindahan/cetak") }}" class="btn btn-warning"><i class="fa fa-download"></i> Cetak</a>
              <a href="{{ url("kepindahan/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>Tanggal Pindah</th>
              <th>Alamat</th>
              <th>Alasan</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transfers as $t)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $t->resident->nik }}</td>
              <td>{{ $t->resident->name }}</td>
              <td>{{ $t->date_of_transfer->format('d/m/Y') }}</td>
              <td><button class="btn btn-primary show-button" data-address="{{$t->destination_address}}" data-regions='@json($t->regions)' data-toggle="modal" data-target="#modal-show">Lihat</button></td>
              <td>{{ $t->alasan }}</td>
              <td class="text-center">
                <div class="form-group">
                  <a href="{{ url("kepindahan/$t->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                  <button type="button" class="btn btn-danger delete-button" data-pindah='@json(['id' => $t->id, 'nama' => $t->resident->name ])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $transfers->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data kepindahan dari <span id="nama-penduduk">-</span>?
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
                <th><strong>Alamat</strong></th>
                <td style="text-align: left">:&nbsp;<span id="address">-</span></td>
              </tr>
              <tr>   
                <th><strong>Desa<strong></th>
                  <td style="text-align: left">:&nbsp;<span id="village">-</span></td>
              </tr>
              <tr>   
                <th><strong>Kecamatan<strong></th>
                  <td style="text-align: left">:&nbsp;<span id="sub-district">-</span></td>
              </tr>
              <tr>   
                <th><strong>Kabupaten<strong></th>
                  <td style="text-align: left">:&nbsp;<span id="district">-</span></td>
              </tr>
              <tr>   
                <th><strong>Provinsi<strong></th>
                  <td style="text-align: left">:&nbsp;<span id="province">-</span></td>
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
      var pindah = $(this).data('pindah');
      var link =  '/kepindahan/' + pindah.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(pindah.nama);
    });
    $('.show-button').on('click', function() {
      var region = $(this).data('regions');
      $('#address').text($(this).data('address') + ',');
      $('#province').text(region[0]);
      $('#district').text(region[1] + ',');
      $('#sub-district').text(region[2] + ',');
      $('#village').text(region[3] + ',');
    });
    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection