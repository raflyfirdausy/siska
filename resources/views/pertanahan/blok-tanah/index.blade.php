{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Blok Tanah |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Blok Tanah
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
              <button class="btn btn-info" data-toggle="modal" data-target="#modal-import"><i class="fa fa-upload"></i> Import</button>
              <a href="{{ url("blok-tanah/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("blok-tanah/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <button type="button" data-toggle="modal" data-target="#modal-create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nomor Blok</th>
              <th>Keterangan</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($landBlocks as $b)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $b->number }}</td>
              <td><button
                class="btn btn-primary show-button"
                data-blok='@json(['note' => $b->note])' 
                data-toggle="modal" data-target="#modal-show">
                  Lihat
              </button></td>
              <td class="text-center">
                <div class="form-group">
                  <button data-url="{{ action('Estate\LandBlockController@update', $b->id) }}" data-block='@json($b)' data-toggle="modal" data-target="#modal-edit" class="edit-button btn btn-warning" style="margin-bottom:0px;">Ubah</button>
                  <button type="button" class="btn btn-danger delete-button" data-blok='@json(['id' => $b->id, 'nomor' => $b->number ])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $landBlocks->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data blok tanah dengan nomor <span id="nomor-blok">-</span>?
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
          <p id="note"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <form action="{{ action('Estate\LandBlockController@store') }}" method="POST" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Data Blok Tanah</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan isi keterangan blok tanah disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nomor Blok Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="number" name="number" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Keterangan <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <form action="-" id="edit-form" method="POST" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ubah Data Blok Tanah <span id="number-title">-</span></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan ubah keterangan blok tanah disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nomor Blok Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="number-edit" name="number" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Keterangan <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <textarea name="note" id="note-edit" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Ubah</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @component('components.import-modal')
  @endcomponent
  <script>
    var url = '{{ url()->current() }}';
    setImportTitle('Import Blok Tanah');
    setImportSubmitLink('{{ url("/blok-tanah/import") }}');
    setImportFormatLink('{{ url("format-import/blok-tanah") }}');
    setImportGuide([
      {col: 'NO', content: 'Nomor baris'},
      {col: 'NOMOR BLOK TANAH', content: 'Nomor blok tanah tersebut'},
      {col: 'KETERANGAN', content: 'Keterangan blok tanah tersebut'},
    ]);

    $('.delete-button').on('click', function() {
      var blok = $(this).data('blok');
      var link =  '/blok-tanah/' + blok.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nomor-blok').text(blok.nomor);
    });

    $('.show-button').on('click', function() {
      var blok = $(this).data('blok');
      $('#note').text(blok.note);
    });

    $('.edit-button').on('click', function() {
      var url = $(this).data('url');
      var data = $(this).data('block')
      $('#edit-form').attr('action', url);
      $('#number-title').text(data.number);
      $('#number-edit').val(data.number);
      $('#note-edit').val(data.note);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection