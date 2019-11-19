{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Surat {{ ucfirst($type) }} |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Surat {{ ucwords($type) }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
            <div class="col-md-7" style="padding-left: 0;">
              <div class="col-md-4" style="padding-right:0; padding-left: 5dp;">
                <div class="input-group">
                  <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                  <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                </div>
              </div>              
              <div class="col-md-4" style="padding-right:0;">
                <select name="jenis" class="form-control" title="Pilih Jenis Surat">
                    <option></option>                    
                    <option value="semua">Semua</option>
                    @foreach($jenis as $j)
                      <option value="{{ $j->type }}">{{ ucwords(strtolower($j->type)) }}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-3" style="padding-right:0;">
                <select name="tahun" class="form-control" title="Tahun">
                    <option></option>
                    <option value="semua">Semua</option>
                    @foreach($tahun as $t)
                    <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-1">
                <div class="input-group">
                  <button type="submit" class="btn btn-primary">Cari</button>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-5">
            <div class="pull-right">
              <button id="btnAddSuratKeluar" class="btn btn-success show-button" data-toggle="modal" data-target="#modal-tambah-edit"><i class="fa fa-plus"></i> Tambah</button>              
              <a href="{{ url("/download-surat-keluar?") }}q={{$ket['q']}}&jenis={{$ket['jenis']}}&tahun={{$ket['tahun']}}" class="btn btn-danger"><i class="fa fa-download"></i> Export</a>                   
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>No</th>                                    
                  <th>Nomor Surat </th>
                  <th>Pengirim</th>
                  <th>Perihal</th>
                  <th>Tanggal Surat</th>
                  <th>{{ $type == "keluar" ? "Di Buat" : "Di Terima" }}</th>
                  <th colspan="3" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($surat as $s)
            <tr>
              <td>{{ $loop->iteration + ($surat->currentPage() * $surat->perPage()) - $surat->perPage() }}</td>          
              <td>{{ $s->nomer }}</td>         
              <td>{{ $s->dari }}</td>
              <td>{{ $s->perihal }}</td>
              <td>{{ $s->tanggal}}</td>
              <td>{{ $s->created_at }}</td>              
              <td>
                <button class="btn btn-info show-button" data-toggle="modal" data-target="#modal-show" data-mail='@json($s)'>Lihat</button>
              </td>
              <td>
                <a href="{{ url("surat-{$type}/{$s->id}/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a>
              </td>
              <td>
                <button type="button" class="btn btn-danger delete-button" data-id="{{ $s->id }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pull-right">
        {{ $surat->appends($_GET)->links() }}
      </div>
    </div>
  </div>
  </div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
<div class="modal fade" id="modal-tambah-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalTambahEdit">Tambah Manual Surat Keluar</h4>
      </div>
      <form id="form_tambah_edit" enctype="multipart/form-data" role="form" method="POST">
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">No Surat</label>
                    <input required type="text" id="no_surat" name="no_surat" class="form-control">
                    <small id="NomerWarning" style="color:red;"></small>                     
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="form-label">Tanggal Surat</label>
                      <input required type="date" id="tanggal_surat" name="tanggal_surat" class="form-control">  
                  </div>
              </div>            
            </div>
            <div class="row">
              <div class="col-md-12">                  
                <div class="form-group">                   
                  <label class="form-label">Jenis Surat</label>   
                  <select required name="jenis" class="form-control" title="Pilih Jenis Surat">                  
                    <option></option>                                          
                    @foreach($jenis as $j)
                      <option value="{{ $j->type }}">{{ ucwords(strtolower($j->type)) }}</option>
                    @endforeach
                    <option value="Surat Lain">Surat Lain</option>
                  </select>
                </div>                  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="form-label">Perihal</label>
                      <textarea name="perihal" id="perihal" rows="2" class="form-control"></textarea>                      
                  </div>
              </div>
            </div>        
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <input type="submit" id="btnSimpan" name="submit" value="Simpan" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="modal fade" id="modal-show-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Foto</h4>
        </div>
        <div class="modal-body">
          <img id="mail-photo" src="-" class="img-responsive">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus surat {{ $type }} ini?
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
          <ul>
            <li><h4>Tanggal Surat :<h4> </li>
            <li id="date">-</li>
            <li><h4>Nomor Surat :<h4> </li>
            <li id="number">-</li>
            <li><h4>{{ $type == 'masuk' ? 'Pengirim' : 'Tujuan' }} :</h4></li>
            <li id="target">-</li>
            <li><h4>Isi Singkat :<h4> </li>
            <li id="summary">-</li>
            <li><h4>Keterangan :<h4> </li>
            <li id="note">-</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    $("#btnAddSuratKeluar").click(function(){
      $("#no_surat").attr("onkeyup", "cekKodeSurat(this, false);");
    });

    function cekKodeSurat(input, isModeEdit = false){
      let kode_surat = input.value.replace(/\s/g,"");
      $.ajax({
          type: 'GET',
          url: '{{ URL::to("/cek-no-surat-lengkap?no_surat=") }}' + kode_surat,
          dataType: 'json',
          success: function(x){
            if(x.count > 0 || input.value.length < 1){
              $("#NomerWarning").text("Nomer surat sudah terdaftar pada database");
              $('#btnSimpan').prop('disabled', true);
            } else {      
              $("#NomerWarning").text("");
              $('#btnSimpan').prop('disabled', false);
            }
          }
      });    
    }

    function cekKodeSurats(input, isModeEdit = false){
      let kodeSurat = kode + " / " + input.value + " / Ds. {{ ucfirst(strtolower(option()->desa->name)) }} / {{ date('Y') }}";      
      $.ajax({
          type: 'GET',
          url: '{{ URL::to("/cek-no-surat?no=") }}' + kodeSurat,
          dataType: 'json',
          success: function(x){
            if(x.count > 0 || input.value.length < 1){
              // $('button[type="submit"]').prop('disabled', true);
              $("#NomerWarning").text("Nomer surat sudah terdaftar pada database");
            } else {              
              // $('button[type="submit"]').prop('disabled', false);
              $("#NomerWarning").text("");
            }
          }
      });
    }

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    }

    $('.delete-button').on('click', function() {
      var id = $(this).data('id');
      var link =  '/surat-{{$type}}/' + id + '/hapus';

      $('#form-delete').attr('action', link);
    });

    $('.show-photo-button').on('click', function() {
      var url = $(this).data('url');

      $('#mail-photo').attr('src', url);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });

    $('.show-button').on('click', function() {
      var mail = $(this).data('mail');
      $('#date').text(mail.date);
      $('#number').text(mail.number);
      $('#target').text(mail.target);
      $('#summary').text(mail.summary);
      $('#note').text(mail.note);
    });
  </script>
@endsection