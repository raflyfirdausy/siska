{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Penerima Bantuan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Daftar</strong> Penerima Bantuan
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
            <a href="{{ url("penerima-bantuan/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
            <a href="{{ url("penerima-bantuan/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
            <button type="button" data-toggle="modal" data-target="#modal-create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
          </div>
        </div>
      </div>
      <table id="posts-table" class="table table-tools table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Jenis Bantuan</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($beneficiaries as $b)
        <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $b->resident->nik }}</td>
        <td>{{ $b->resident->name }}</td>
        <td>{{ $b->type->name }}</td>
        <td class="text-center">
          <div class="form-group">
            <button data-bantuan='@json($b->type)' data-penduduk='@json(['nama' => $b->resident->name, 'nik' => $b->resident->nik])' data-url="{{ url("penerima-bantuan/$b->id/ubah") }}" class="btn btn-warning edit-button" style="margin-bottom: 0;" data-toggle="modal" data-target="#modal-edit"> Ubah</button>
            <button type="submit" class="btn btn-danger delete-button" data-bantuan='@json(['id' => $b->id, 'nama' => $b->resident->name])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
          </div>
        </td>
        <td></td>
        </tr>
        @endforeach
      </tbody>
      </table>
      
    </div>
    <div class="pull-right">
      {{ $beneficiaries->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data penerima bantuan dari <span id="nama-penduduk">-</span>?
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
      <form action="{{ url("penerima-bantuan/tambah") }}" method="POST" data-parsley-validate>
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tambah Data Penerima Bantuan</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan menambahkan data penerima bantuan baru disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
                    <div class="col-md-10">
                      <input class="form-control" name="nik" id="nik" type="text" required autocomplete="false">
                      <div style="position: relative;" id="recommendation-list"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nama</label>
                    <div class="col-md-10">
                      <input class="form-control" id="nama" type="text" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jenis Bantuan</label>
                    <div class="col-md-10">
                      <select name="beneficiary_type_id" title="Pilih salah satu">
                        <option></option>
                        @foreach ($types as $t)
                          <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Simpan</button>
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
            <h4 class="modal-title" id="myModalLabel">Ubah Data Penerima Bantuan</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Silahkan ubah data penerima bantuan disini</label>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
                    <div class="col-md-10">
                      <input class="form-control" name="nik" id="nik-edit" type="text" disabled autocomplete="false">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Nama</label>
                    <div class="col-md-10">
                      <input class="form-control" id="name-edit" type="text" disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jenis Bantuan</label>
                    <div class="col-md-10">
                      <select name="beneficiary_type_id" id="beneficiary_type_id-edit" title="Pilih salah satu">
                        <option></option>
                        @foreach ($types as $t)
                          <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    var url = "{{ URL::to('/') }}";
  
    function chooseResident(nik, name) {
      $('#nik').attr('value', nik);
      $('#nama').attr('value', name);
      $('#recommendation-list').fadeOut();
    }

    function getResident() {
      var nik = $('#nik').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info', function(data) {
          if (data.length > 0) {
              $('#recommendation-list').empty();
              $('#recommendation-list').fadeIn();
              $('#recommendation-list').append('<ul id="recommendation" class="dropdown-menu" style="display:block; position:absolute">');
              $.each(data, function(key, value) {
                $('#recommendation').append(`<li 
                  onclick="chooseResident('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
          else {
            transferFields[1].empty();
          }
        });
      }
    }
    

    $(document).ready(function() {
      $('#nik').on('keyup', getResident);
      $('.delete-button').on('click', function() {
        var bantuan = $(this).data('bantuan');
        var link =  '/penerima-bantuan/' + bantuan.id + '/hapus';

        $('#nama-penduduk').text(bantuan.nama);

        $('#form-delete').attr('action', link);
      });

      $('#delete-confirm').on('click', function() {
        $('#modal-confirm').modal('hide');
      });

      $('.edit-button').on('click', function() {
        var url = $(this).data('url');
        var penduduk = $(this).data('penduduk')
        var bantuan = $(this).data('bantuan')
        $('#edit-form').attr('action', url);
        $('#nik-edit').val(penduduk.nik);
        $('#name-edit').val(penduduk.nama);
        $(`#beneficiary_type_id-edit`).val(bantuan.id);
        $('span.filter-option.pull-left').text(bantuan.name)
      });
    });
  </script>
@endsection