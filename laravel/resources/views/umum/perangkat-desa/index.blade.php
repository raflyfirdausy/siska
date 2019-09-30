{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Perangkat Desa |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Perangkat</strong> Desa
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
              <button type="button" data-toggle="modal" data-target="#modal-create" class="create-button btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>&ThickSpace;</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($officials as $o)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td style="width:10%"><img style="width: 100%;" src="{{ $o->foto }}" class="img-thumbnail"></td>
              <td>{{ $o->nip }}</td>
              <td>{{ $o->name }}</td>
              <td>{{ $o->jabatan }}</td>
              <td class="text-center">
                <div class="form-group">
                  <button data-url="{{ action('General\OfficialController@update', $o->id) }}" data-official='@json($o)' data-position="{{ $o->jabatan }}" data-toggle="modal" data-target="#modal-edit" class="edit-button btn btn-warning" style="margin-bottom:0px;">Ubah</button>
                  <button type="button" class="btn btn-danger delete-button" data-official='@json(['id' => $o->id])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
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
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus perangkat desa ini?
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
      <form action="{{ action('General\OfficialController@store') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Perangkat Desa</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan isi keterangan perangkat desa disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Foto <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="file" class="form-control" name="photo" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">NIP <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" name="nip" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nama <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="name" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jabatan <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="position" title="Pilih salah satu" class="form-control">
                        <option></option>
                        <option value="kepala_desa">Kepala Desa</option>
                        <option value="sekretaris_desa">Sekretaris Desa</option>
                        <option value="kaur_umum">Kaur Umum</option>
                        <option value="kaur_pemerintahan">Kaur Pemerintahan</option>
                        <option value="kaur_keuangan">Kaur Keuangan</option>
                        <option value="kaur_pembangunan">Kaur Pembangunan</option>
                        <option value="kaur_keamanan_dan_ketertiban">Kaur Keamanan dan Ketertiban</option>
                      </select>
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
      <form id="edit-form" action="-" method="POST" enctype="multipart/form-data" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Ubah Data Kelas Tanah <span id="code-title">-</span></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan ubah keterangan perangkat disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Foto</label>
                    <div class="col-md-12">
                      <input type="file" class="form-control" name="photo" autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">NIP</label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" id="nip" name="nip" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nama</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="name" name="name" required autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jabatan</label>
                    <div class="col-md-12">
                      <select name="position" id="position" title="Pilih salah satu" class="form-control">
                        <option></option>
                        <option value="kepala_desa">Kepala Desa</option>
                        <option value="sekretaris_desa">Sekretaris Desa</option>
                        <option value="kaur_umum">Kaur Umum</option>
                        <option value="kaur_pemerintahan">Kaur Pemerintahan</option>
                        <option value="kaur_keuangan">Kaur Keuangan</option>
                        <option value="kaur_pembangunan">Kaur Pembangunan</option>
                        <option value="kaur_keamanan_dan_ketertiban">Kaur Keamanan dan Ketertiban</option>
                      </select>
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
  <script>
    $('.delete-button').on('click', function() {
      var official = $(this).data('official');
      var link =  '/perangkat-desa/' + official.id + '/hapus';

      $('#form-delete').attr('action', link);
    });

    $('.create-button').on('click', function() {
      $('span.filter-option.pull-left').text('Pilih salah satu');
    });

    $('.edit-button').on('click', function() {
      var url = $(this).data('url');
      var data = $(this).data('official');
      $('#edit-form').attr('action', url);
      $('#nip').val(data.nip);
      $('#name').val(data.name);
      $('#position').val(data.nip);
      console.log($(`#position[value=${data.position}]`));
      $('span.filter-option.pull-left').text($(this).data('position'));
      $(`#position`).val(data.position)
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection