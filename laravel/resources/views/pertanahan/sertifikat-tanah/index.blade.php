{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Sertifikat Tanah |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Sertifikat Tanah
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
              <button data-toggle="modal" data-target="#modal-import" class="btn btn-info"><i class="fa fa-upload"></i> Import</button>
              <a href="{{ url("sertifikat-tanah/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("sertifikat-tanah/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <a href="{{ url("sertifikat-tanah/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nomor Sertifikat</th>
              <th>Pemilik Saat Ini</th>
              <th>Pemilik Sebelumnya</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lands as $l)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $l->number }}</td>
              <td>{{ $l->resident->name }}</td>
              <td><button
                class="btn btn-primary show-button"
                data-sertifikat='@json(['pemilik' => $l->owners])' 
                data-toggle="modal" data-target="#modal-show">
                  Lihat
              </button></td>
              <td class="text-center">
                <div class="form-group">
                  <a href="{{ action('Estate\LandCertificateController@edit', $l->id) }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                  <button type="button" class="btn btn-danger delete-button" data-sertifikat='@json(['id' => $l->id, 'nama' => $l->resident->name ])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $lands->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data sertifikat tanah milik <span id="nama-penduduk">-</span>?
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
          <div id="owner-list">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @component('components.import-modal') 
  @endcomponent
  <script>
    setImportTitle('Import Sertifikat Tanah');
    setImportSubmitLink('{{ url("/sertifikat-tanah/import") }}');
    setImportFormatLink('{{ url("format-import/sertifikat-tanah") }}');
    setImportGuide([
      {col: 'NO', content: 'Nomor baris'},
      {col: 'NOMOR SERTIFIKAT', content: 'Nomor sertifikat dari tanah tersebut'},
      {col: 'PEMILIK SAAT INI', content: 'NIK dari pemilik saat ini, pemilik harus sudah terdaftar sebagai penduduk dalam sistem'},
      {col: 'PEMILIK SEBELUMNYA', content: 'Isi dengan format NIK|tahun dan tiap pemilik pisahkan dengan koma, contoh : 323131|2019,32141|2018'},
      {col: '', content: 'NIK pemilik sebelumnya harus sudah terdaftar sebagai penduduk dalam sistem'},
    ]);

    $('.delete-button').on('click', function() {
      var sertifikat = $(this).data('sertifikat');
      var link =  '/sertifikat-tanah/' + sertifikat.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(sertifikat.nama);
    });

    $('.show-button').on('click', function() {
      var pemilik = $(this).data('sertifikat').pemilik;
      var ownerList = $('#owner-list');
      ownerList.empty();
      var table = '<table class="table table-striped">';
      table += '<thead><th>Nama</th><th>Tahun</></thead>';
      table += '<tbody>';
      for (var i = 0; i < pemilik.length; i++ ) {
        table += `<tr><td>${pemilik[i].resident.name}</td><td>${pemilik[i].year})</td></tr>`;
      }
      table += '</tbody>';
      ownerList.append(table);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection