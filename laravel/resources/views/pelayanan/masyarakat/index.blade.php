{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Pendaftaran Masyarakat |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Pendaftaran</strong> Masyarakat
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
              <button class="btn btn-success" data-toggle="modal" data-target="#modal-create"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>#</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Pin</th>
                  <th>Tanggal Buat</th>
                  <th>Login Terakhir</th>
                  <th colspan="3" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody id="pelayanan">
            @foreach($pelayanan as $p)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$p->resident->nik}}</td>
              <td>{{$p->resident->nik}}</td>
              <td>{{$p->pin}}</td>
              <td>{{$p->date_created->format('d/m/Y')}}</td>
              <td>{{$p->last_login->format('d/m/Y')}}</td>
              <td>
              <a class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{ $p->id_pend }}">Hapus</a>
                    <div id="myModal-{{ $p->id_pend }}" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Perhatian</h4>
                          </div>
                          <div class="modal-body">
                              Apakah Anda yakin ingin menghapus data masyarakat {{ $p->resident->name }}?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <a href="/pendaftaran/{{ $p->id }}/hapus" class="btn btn-danger">Hapus</a>
                          </div>
                        </div>

                      </div>
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
  <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Pendaftaran Masyarakat</h4>
        </div>

        <form action="{{ url('pendaftaran/tambah') }}" method="POST" name="myform">
          {{ csrf_field() }}
          <input type="hidden" name="length" value="6">
          <div class="modal-body">
            <div class="form-group">
              <label>NIK</label>
              <input class="form-control" name="nik" id="nik" type="text" required autocomplete="false">
              <div style="position: relative;" id="recommendation-list"></div>
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input class="form-control" id="nama" type="text" disabled autocomplete="false">
            </div>
            <div class="form-group">
              <label>PIN</label>
              <input name="pin" type="text" class="form-control" placeholder="123456" value="">&nbsp;
              <input type="button" class="button" value="Generate" onClick="generate();" tabindex="2">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button class="btn btn-success">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $('.delete-button').on('click', function() {
      var id = $(this).data('id');
      var link =  '/pendaftaran/' + id + '/hapus';

      $('#form-delete').attr('action', link);
    });
    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });

    var url = "{{ URL::to('/') }}";
  
    function chooseResident(nik, name) {
      $('#nik').attr('value', nik);
      $('#nama').attr('value', name);
      $('#recommendation-list').fadeOut();
    }

    $('#nik').on('keyup', getResident);

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

    function randomPassword(length) {
    var chars = "1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
    }

    function generate() {
        myform.pin.value = randomPassword(myform.length.value);
    }
  </script>
  
@endsection