{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Laporan Masyarakat |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Laporan</strong> Masyarakat
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
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Pengirim</th>
                  <th>Email</th>
                  <th>Nomor Ponsel</th>
                  <th>Artikel</th>
                  <th>Isi Komentar</th>
                  <th>Dilaporkan Pada</th>
                  <th>Ditindaklanjuti</th>
                  <th text-align="center">Aksi</th>
              </tr>
          </thead>
          <tbody id="pelayanan">

            @foreach($comment as $a)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{$a->resident->name}}</td>
              <td>{{$a->email}}</td>
              <td>{{$a->phone}}</td>
              <td>{{'Dummy'}}</td>
              <td>{{$a->comment}}</td>
              <td>{{$a->date_created->format('d/m/Y')}}</td>
              <td>
                <select name="proceeded" class="proceeded" data-id="{{ $a->id }}">
                  <option value="belum" {{ $a->proceeded == 'belum' ? 'selected' : '' }}>Belum</option>
                  <option value="sudah" {{ $a->proceeded == 'sudah' ? 'selected' : '' }}>Sudah</option>
                </select>
              <td>
                <a class="btn btn-danger" data-toggle="modal" data-target="#myModal-{{$loop->index}}">Hapus</a>
                <div id="myModal-{{$loop->index}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <form action="{{ url("laporan/$a->id/hapus") }}" method="POST">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Perhatian</h4>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus laporan ini?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-danger">Hapus</a>
                        </div>
                      </div>
                    </form>
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
<script type="text/javascript">
  var url = "{{ URL::to('/') }}";

  $('.proceeded').on('change', function() {
    var id = $(this).data('id');
    var data = $(this).val();
    console.log(data);
    $.getJSON(`${url}/laporan-masuk/${id}/ubah?status=${data}`, () => {});
  });
</script>
@endsection


{{-- <table class="table table-striped">
    <tr>
      <th><strong>Nama Penduduk</strong></th>
      <td style="text-align: left">:&nbsp;<span>{{$a->resident['name']}}</span></td>
    </tr>
    <tr>   
      <th><strong>Nik<strong></th>
        <td style="text-align: left">:&nbsp;<span>{{$a->resident['nik']}}</span></td>
    </tr>
    <tr>   
      <th><strong>Artikel<strong></th>
        <td style="text-align: left">:&nbsp;<span>{{'Dummy'}}</span></td>
    </tr>
    <tr>   
      <th><strong>Email<strong></th>
        <td style="text-align: left">:&nbsp;<span>{{$a->email}}</span></td>
    </tr>
    <tr>   
      <th><strong>Nomor Ponsel<strong></th>
        <td style="text-align: left">:&nbsp;<span>{{$a->phone}}</span></td>
    </tr>
    <tr>    
      <th><strong>Komentar</strong></th>
      <td style="text-align: left">:&nbsp;<span>{{$a->comment}}</span></td>
    </tr>
    <tr>    
      <th><strong>Tanggal Komentar</strong></th>
      <td style="text-align: left">:&nbsp;<span>{{$a->tgl_upload}}</span></td>
    </tr>
    <tr>    
      <th><strong>Status</strong></th>
      <td style="text-align: left">:&nbsp;<span>{{$a->status}}</span></td>
    </tr>
  </table> --}}