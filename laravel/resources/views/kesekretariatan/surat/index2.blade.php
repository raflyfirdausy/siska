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
              @if ($type == "keluar")
              <div class="col-md-4" style="padding-right:0;">
                <select name="jenis" class="form-control" title="Pilih Jenis Surat">
                    <option></option>                    
                    <option value="semua">Semua</option>
                    @foreach($jenis as $j)
                      <option value="{{ $j->type }}">{{ ucwords(strtolower($j->type)) }}</option>
                    @endforeach
                </select>
              </div>
              @endif
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
              <a href="{{ url("/download-surat-$type?") }}q={{$ket['q']}}&jenis={{$ket['jenis']}}&tahun={{$ket['tahun']}}" class="btn btn-danger"><i class="fa fa-download"></i> Export</a>                   
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>No</th>                                    
                  <th>Nomor Surat </th>
                  @if ($type == "masuk")
                    <th>Pengirim</th>
                  @endif                  
                  <th>Perihal</th>
                  <th>Tanggal Surat</th>
                  <th>{{ $type == "keluar" ? "Di Buat" : "Di Terima" }}</th>
                  <th colspan="2" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($surat as $s)
            <tr>
              <td>{{ $loop->iteration + ($surat->currentPage() * $surat->perPage()) - $surat->perPage() }}</td>          
              <td>{{ $s->nomer }}</td>  
              @if ($type == "masuk")
                <td>{{ $s->dari }}</td>
              @endif                         
              <td>{{ $s->perihal }}</td>
              <td>{{ $s->tanggal}}</td>
              <td>{{ $s->created_at }}</td>              
              {{-- <td>
                <button class="btn btn-info show-button" data-toggle="modal" data-target="#modal-show" data-mail='@json($s)'>Lihat</button>
              </td> --}}
              <td>
                  <button class="btn btn-warning show-button editData" data-toggle="modal" data-target="#modal-tambah-edit" data-surat='@json($s)'>Ubah</button>
                  {{-- <a href="{{ url("surat-{$type}/{$s->id}/ubah") }}" class="btn btn-warning" style="margin-bottom:0px;">Ubah</a> --}}
              </td>
              <td>
                <button type="button" class="btn btn-danger hapusData" data-id="{{ $s->id }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
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
        @csrf
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">No Surat</label>
                    <input required type="text" id="no_surat" name="no_surat" class="form-control">
                    <small id="NomerWarning" style="color:red;"></small>     
                    <input type="hidden" name="id_surat" id="id_surat">                
                </div>
              </div>
            </div>
            @if ($type == "masuk")
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label class="form-label">Pengirim</label>
                      <input required type="text" id="pengirim" name="pengirim" class="form-control">                                  
                  </div>
                </div>
              </div>
            @endif            
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="form-label">Tanggal Surat</label>
                      <input required type="date" id="tanggal_surat" name="tanggal_surat" class="form-control">  
                  </div>
              </div>            
            </div>
            @if ($type == "keluar")
              <div class="row">
                <div class="col-md-12">                  
                  <div class="form-group">                   
                    <label class="form-label">Jenis Surat</label>   
                    <select required name="jenis_surat" id="jenis_surat" class="form-control" title="Pilih Jenis Surat">                  
                      <option></option>       
                        <option value="SURAT KETERANGAN TANAH">{{ ucwords("SURAT KETERANGAN TANAH") }}</option>
                        <option value="SURAT KETERANGAN USAHA">{{ ucwords("SURAT KETERANGAN USAHA") }}</option>
                        <option value="SURAT KETERANGAN KEMATIAN">{{ ucwords("SURAT KETERANGAN KEMATIAN") }}</option>
                        <option value="SURAT KETERANGAN DOMISILI LEMBAGA">{{ ucwords("SURAT KETERANGAN DOMISILI LEMBAGA") }}</option>
                        <option value="SURAT KETERANGAN DOMISILI">{{ ucwords("SURAT KETERANGAN DOMISILI") }}</option>
                        <option value="SURAT KETERANGAN BEDA IDENTITAS">{{ ucwords("SURAT KETERANGAN BEDA IDENTITAS") }}</option>
                        <option value="SURAT PENGANTAR KTP">{{ ucwords("SURAT PENGANTAR KTP") }}</option>
                        <option value="SURAT PENGANTAR SKCK">{{ ucwords("SURAT PENGANTAR SKCK") }}</option>
                        <option value="SURAT PENGANTAR UMUM">{{ ucwords("SURAT PENGANTAR UMUM") }}</option>
                        <option value="SURAT KETERANGAN TIDAK MAMPU">{{ ucwords("SURAT KETERANGAN TIDAK MAMPU") }}</option>
                        <option value="SURAT KETERANGAN TANAH">{{ ucwords("SURAT KETERANGAN USAHA") }}</option>
                        <option value="SURAT KETERANGAN TANAH">{{ ucwords("SURAT KETERANGAN USAHA") }}</option>
                        <option value="SURAT LAINNYA">{{ ucwords("SURAT LAINNYA") }}</option>
                    </select>
                  </div>                  
                </div>
              </div>
            @endif            
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
            @csrf
            <input type="hidden" name="hapus_id" id="hapus_id">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger" id="delete-confirm">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>

    $("#btnAddSuratKeluar").click(function(){
      $('form').trigger("reset");
      $("#no_surat").attr("onkeyup", "cekKodeSurat(this);");
      $("#NomerWarning").text("");
      $("#form_tambah_edit").attr("action", '{{ URL::to("/tambah-surat-$type") }}');
    });

    $('.editData').on('click', function() {
      $("#form_tambah_edit").attr("action", '{{ URL::to("/edit-surat-$type") }}');
      $("#NomerWarning").text("");

      let surat = $(this).data('surat');          
      $("#id_surat").attr("value", surat.id);
      $("#no_surat").attr("onkeyup", "cekKodeSurat(this, '" + surat.nomer + "');");
      $('#no_surat').val(surat.nomer);
      $('#tanggal_surat').val(surat.tanggal);    
      $('#jenis_surat').val(surat.type);      
      $('#perihal').val(surat.perihal);      
      $('#pengirim').val(surat.dari);    
    });    

    $('.hapusData').on('click', function() {
      var id = $(this).data('id');      
      $("#hapus_id").attr("value", id);
      $('#form-delete').attr('action', '{{ URL::to("/hapus-surat-$type") }}');
    });    

    function cekKodeSurat(input, nomerSurat = null){         
      let kode_surat = input.value.replace(/\s/g,"");        

      var CekAjak = true;
      if(nomerSurat != null){
        let nomerSurat_ = nomerSurat.replace(/\s/g,"");
        if(kode_surat == nomerSurat_){
          $("#NomerWarning").text("");
          CekAjak = false;        
        }
      }
      
      if(CekAjak){
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

    $('.show-photo-button').on('click', function() {
      var url = $(this).data('url');

      $('#mail-photo').attr('src', url);
    });

    $('#delete-confirm').on('click', function() {
      $('#modal-confirm').modal('hide');
    });

    
  </script>
@endsection