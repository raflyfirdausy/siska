{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Pendatang |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Pendatang
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
              {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
              <a href="{{ url("pendatang/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("pendatang/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <a href="{{ url("pendatang/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Nomor KK</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Alamat Asal</th>
                  <th>Alamat Saat Ini</th>
                  <th class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($newcomers as $n)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $n->resident->family->no_kk }}</td>
              <td>{{ $n->resident->nik }}</td>
              <td>{{ $n->resident->name }}</td>
              <td><button class="btn btn-primary show-origin-address-button" data-detail='@json(['rt' => $n->rt, 'rw' => $n->rw, 'name' => $n->village_name])' data-address="{{$n->address}}" data-regions='@json($n->regions)' data-toggle="modal" data-target="#modal-show">Lihat</button></td>
              <td><button class="btn btn-primary show-destination-address-button" data-detail='@json(['rt' => $n->resident->family->rt, 'rw' => $n->resident->family->rw, 'name' => $n->resident->family->village_name])' data-address="{{$n->resident->family->address}}" data-regions='@json($n->resident->family->regions)' data-toggle="modal" data-target="#modal-show">Lihat</button></td>
              <td class="text-center">
                <div class="form-group">
                    <a href="{{ url("pendatang/$n->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                  <button type="submit" class="btn btn-danger delete-button" data-pendatang='@json(['id' => $n->id, 'nama' => $n->resident->name])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
              <td></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $newcomers->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data pendatang dari <span id="nama-penduduk">-</span>?
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
            <h4 class="modal-title" id="myModalLabel">Informasi <span id="alamat"></span></h4>
          </div>
          <div class="modal-body">
            <table class="table table-striped">
                <tr>
                  <th><strong>Alamat</strong></th>
                  <td style="text-align: left">:&nbsp;<span id="address">-</span> <span id="detail">-</span></td>
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
      var pendatang = $(this).data('pendatang');
      var link =  '/pendatang/' + pendatang.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(pendatang.nama);
    });

    $('.show-origin-address-button').on('click', function() {
      var region = $(this).data('regions');
      var details = $(this).data('detail');
      $('#alamat').text('Alamat Asal');
      $('#detail').text(`RT:${details.rt}/RW:${details.rw}, ${details.name}`);
      $('#address').text($(this).data('address') + ',');
      $('#province').text(region[0]);
      $('#district').text(region[1] + ',');
      $('#sub-district').text(region[2] + ',');
      $('#village').text(region[3] + ',');
    });

    $('.show-destination-address-button').on('click', function() {
      var region = $(this).data('regions');
      var details = $(this).data('detail');
      $('#alamat').text('Alamat Saat Ini');
      $('#detail').text(`RT:${details.rt}/RW:${details.rw}, ${details.name}`);
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