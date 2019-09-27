{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Kelahiran |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Kelahiran
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
              <a href="{{ url("kelahiran/export") }}" class="btn btn-primary"><i class="fa fa-download"></i> Export</a>
              <a href="{{ url("kelahiran/cetak") }}" class="btn btn-warning"><i class="fa fa-print"></i> Cetak</a>
              <a href="{{ url("kelahiran/tambah") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Bayi</th>
              <th>Nama Ibu</th>
              <th>Nama Bapak</th>
              <th>Tanggal Lahir</th>
              <th>Detail</th>
              <th colspan="2" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($births as $b)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $b->resident->name }}</td>
              <td>{{ $b->mother->name }}</td>
              <td>{{ $b->father->name }}</td>
              <td>{{ $b->date_of_birth->format('d/m/Y') }}</td>
              <td><button
                class="btn btn-primary show-button"
                data-kelahiran='@json($b)' 
                data-toggle="modal" data-target="#modal-show">
                  Lihat
              </button></td>
              <td class="text-center">
                <div class="form-group">
                  <a href="{{ url("/kelahiran/$b->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
                  <button type="button" class="btn btn-danger delete-button" data-lahir='@json(['id' => $b->id, 'nama' => $b->resident->name ])' data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $births->appends($_GET)->links() }}
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
          Apakah Anda yakin akan menghapus data kelahiran dari <span id="nama-penduduk">-</span>?
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
              <th><strong>Berat</strong></th>
              <td style="text-align: left">:&nbsp;<span id="weight">-</span>kg</td>
            </tr>
            <tr>   
              <th><strong>Tinggi<strong></th>
                <td style="text-align: left">:&nbsp;<span id="height">-</span>cm</td>
            </tr>
            <tr>   
              <th><strong>Waktu Lahir<strong></th>
                <td style="text-align: left">:&nbsp;<span id="time_of_birth">-</span></td>
            </tr>
            <tr>   
              <th><strong>Tempat Lahir<strong></th>
                <td style="text-align: left">:&nbsp;<span id="place_of_birth">-</span></td>
            </tr>
            <tr>   
              <th><strong>Anak Ke<strong></th>
                <td style="text-align: left">:&nbsp;<span id="child_number">-</span></td>
            </tr>
            <tr>   
              <th><strong>Tempat Persalinan<strong></th>
                <td style="text-align: left">:&nbsp;<span id="labor_place">-</span></td>
            </tr>
            <tr>   
              <th><strong>Pembantu Persalinan<strong></th>
                <td style="text-align: left">:&nbsp;<span id="labor_helper">-</span></td>
            </tr>
            <tr>   
              <th><strong>Pelapor<strong></th>
                <td style="text-align: left">:&nbsp;<span id="reporter">-</span></td>
            </tr>
            <tr>   
              <th><strong>Hubungan Pelapor<strong></th>
                <td style="text-align: left">:&nbsp;<span id="reporter_relation">-</span></td>
            </tr>
            <tr>   
              <th><strong>Saksi Pertama<strong></th>
                <td style="text-align: left">:&nbsp;<span id="first_witness">-</span></td>
            </tr>
            <tr>   
              <th><strong>Saksi Kedua<strong></th>
                <td style="text-align: left">:&nbsp;<span id="second_witness">-</span></td>
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
      var lahir = $(this).data('lahir');
      var link =  '/kelahiran/' + lahir.id + '/hapus';

      $('#form-delete').attr('action', link);
      $('#nama-penduduk').text(lahir.nama);
    });

    $('.show-button').on('click', function() {
      var kelahiran = $(this).data('kelahiran');
      for (var key of Object.keys(kelahiran)) {
        $('#' + key).text(kelahiran[key]);
      }
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });
  </script>
@endsection