{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Penduduk |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Penduduk
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
            <div class="col-md-8" style="padding-left: 0;">
              <div class="col-xs-5">
                <div class="input-group">
                  <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                  <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                </div>
              </div>
              <div class="col-xs-7">
                <div class="input-group">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                  &ThinSpace;
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-filter-search"><i class="fa fa-filter"></i> Filter</button>
                  &ThinSpace;
                  <a href="{{ url()->current() }}" class="btn btn-warning"><i class="fa fa-refresh"></i> Ulang</a>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-4">
            <div class="pull-right">
              <a href="{{ url("penduduk/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("penduduk/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>#</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>TTL</th>
                  <th>Pendidikan</th>
                  <th>Pekerjaan</th>
                  <th colspan="3" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($residents as $r)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $r->nik }}</td>
              <td>{{ $r->name }}</td>
              <td>{{ $r->jenkel }}</td>
              <td>{{ $r->birth_place }}, {{ $r->birthday->format('d/m/Y') }}</td>
              <td>{{ $r->education->name }}</td>
              <td>{{ $r->occupation->name }}</td>
              <td>
                <a href="{{ url("penduduk/$r->nik") }}" class="btn btn-info" style="margin-bottom:0px;">Lihat</a>
              </td>
              <td>
                <a href="{{ url("penduduk/$r->nik"."/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>  
              </td>
              <td>
                <a href="#" data-penduduk='@json($r)' class="btn btn-danger delete-button" style="margin-bottom:0px;" data-toggle="modal" data-target="#modal-confirm">Hapus</a>  
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $residents->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus penduduk <span id="nama-penduduk">-</span>?
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
  <div class="modal fade" id="modal-filter-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ url()->current() }}" method="GET">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Pencarian Detail</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="detail" value="1">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-md-12 form-label">Umur </label>
                <div class="col-md-6">
                    <input class="form-control" name="umur" type="number">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jenis Kelamin </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="jenis_kelamin">
                        <option></option>
                        <option>-</option>
                        <option value="pria">Laki - Laki</option>
                        <option value="wanita">Perempuan</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Golongan Darah</label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="golongan_darah">
                        <option></option>
                        <option>-</option>
                        <option value="a">A</option>                       
                        <option value="b">B</option>                       
                        <option value="ab">AB</option>                       
                        <option value="o">O</option>                       
                        <option value="a+">A+</option>                       
                        <option value="b+">B+</option>                       
                        <option value="ab+">AB+</option>                       
                        <option value="o+">O+</option>                       
                        <option value="a-">A-</option>                       
                        <option value="b-">B-</option>                       
                        <option value="ab-">AB-</option>                       
                        <option value="o-">O-</option>                       
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kewarganegaraan </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="kewarganegaraan">
                        <option></option>
                        <option>-</option>
                        <option value="wni">WNI</option>
                        <option value="wna">WNA</option>
                        <option value="dwi">Dwikewarganegaraan</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Agama </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="agama">
                        <option></option>
                        <option>-</option>
                        <option value="islam">Islam</option>
                        <option value="kristen">Kristen</option>
                        <option value="katolik">Katolik</option>
                        <option value="hindu">Hindu</option>
                        <option value="buddha">Buddha</option>
                        <option value="konghucu">Konghucu</option>
                        <option value="kepercayaan">Kepercayaan</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Status Perkawinan </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="status_perkawinan">
                        <option></option>
                        <option>-</option>
                        <option value="kawin">Kawin</option>
                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="cerai_hidup">Cerai Hidup</option>
                        <option value="cerai_mati">Cerai Mati</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Status Kependudukan </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="status_kependudukan">
                        <option></option>
                        <option>-</option>
                        <option value="asli">Asli</option>
                        <option value="pendatang">Pendatang</option>
                        <option value="pindah">Pindahan</option>
                        <option value="sementara">Sementara</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Pendidikan Terakhir </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="pendidikan">
                        <option></option>
                        <option>-</option>
                        @foreach ($educations as $e)
                          <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Pekerjaan </label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="pekerjaan">
                        <option></option>
                        <option>-</option>
                        @foreach ($occupations as $o)
                          <option value="{{ $o->id }}">{{ $o->name }}</option>
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
            <button type="submit" class="btn btn-success" id="delete-confirm">Cari</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $('.delete-button').on('click', function() {
      var penduduk = $(this).data('penduduk');
      var link =  '/penduduk/' + penduduk.nik + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(penduduk.name);
    });
    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection