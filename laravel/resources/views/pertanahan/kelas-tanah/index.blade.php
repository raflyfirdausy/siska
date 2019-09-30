{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Kelas Tanah |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Kelas Tanah
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
              <a href="{{ url("kelas-tanah/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("kelas-tanah/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <button type="button" data-toggle="modal" data-target="#modal-create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Harga</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($landClasses as $c)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $c->code }}</td>
              <td>{{ $c->harga }}</td>
              <td class="text-center">
                <div class="form-group">
                  <button data-url="{{ action('Estate\LandClassController@update', $c->id) }}" data-class='@json($c)' data-toggle="modal" data-target="#modal-edit" class="edit-button btn btn-warning" style="margin-bottom:0px;">Ubah</button>
                  <button type="button" class="btn btn-danger delete-button" data-kelas='@json(['id' => $c->id])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $landClasses->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data kelas tanah ini?
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
  <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <form action="{{ action('Estate\LandClassController@store') }}" method="POST" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Data Kelas Tanah</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan isi keterangan kelas tanah disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kode Kelas Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="code" name="code" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Harga Kelas Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" id="price" name="price" required autocomplete="false">
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
      <form id="edit-form" action="-" method="POST" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ubah Data Kelas Tanah <span id="code-title">-</span></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan ubah keterangan kelas tanah disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kode Kelas Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="code-edit" name="code" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Harga Kelas Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" id="price-edit" name="price" required autocomplete="false">
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
    setImportTitle('Import Kelas Tanah');
    setImportSubmitLink('{{ url("/kelas-tanah/import") }}');
    setImportFormatLink('{{ url("format-import/kelas-tanah") }}');
    setImportGuide([
      {col: 'NO', content: 'Nomor baris'},
      {col: 'KODE', content: 'Kode dari kelas tanah tersebut'},
      {col: 'HARGA', content: 'Harga kelas tanah, gunakan angka tanpa koma, contoh : 2000000'},
    ]);
    $('.delete-button').on('click', function() {
      var kelas = $(this).data('kelas');
      var link =  '/kelas-tanah/' + kelas.id + '/hapus';

      $('#form-delete').attr('action', link);
    });

    $('.edit-button').on('click', function() {
      var url = $(this).data('url');
      var data = $(this).data('class')
      $('#edit-form').attr('action', url);
      $('#code-title').text(data.code);
      $('#code-edit').val(data.code);
      $('#price-edit').val(data.price);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection