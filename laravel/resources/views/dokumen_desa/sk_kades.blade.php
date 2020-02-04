{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Surat Keputusan Kepala Desa |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Daftar</strong> Surat Keputusan Kepala Desa
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
                  <input name="q" type="text" value="{{ $ket['q'] }}" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                </div>
              </div>                                          
              <div class="col-md-4" style="padding-right:0;">
                <select name="bulan" class="form-control" title="Bulan">
                    <option value=""></option>
                    <option value="semua">Semua</option>                    
                    <option value="01">Januari</option>                    
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="08">Juli</option>
                    <option value="09">Agustus</option>
                    <option value="10">September</option>
                    <option value="11">Oktober</option>
                    <option value="12">Novemebr</option>

                </select>
              </div>              
              <div class="col-md-3" style="padding-right:0;">
                <select name="tahun" class="form-control" title="Tahun">
                    <option></option>
                    <option value="semua">Semua</option>
                    @foreach($tahun as $t)
                        <option value="{{ $t->tahun }}" >{{ $t->tahun }}</option>
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
              <a href="{{ url("/download-surat-keputusan-kades?") }}q={{$ket['q']}}&bulan={{$ket['bulan']}}&tahun={{$ket['tahun']}}" class="btn btn-danger"><i class="fa fa-download"></i> Export</a>                   
            </div>
          </div>
        </div>
        <table id="posts-table" class="table table-tools table-striped">
          <thead>
              <tr>
                  <th>No</th>                                    
                  <th>Nomor & Tgl SK Kades</th>            
                  <th>Tentang</th>
                  <th>Uraian Singkat</th>
                  <th>Nomor & Tgl Diundangkan</th>
                  <th>Keterangan</th>
                  <th colspan="2" class="text-center">Aksi</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($sk as $s)
            <tr>
              <td>{{ $loop->iteration + ($sk->currentPage() * $sk->perPage()) - $sk->perPage() }}</td>                        
              <td>{{ $s->no_kades }}<br>{{ $s->tgl_kades }}</td>
              <td>{{ $s->tentang }}</td>
              <td>{{ $s->uraian }}</td>
              <td>{{ $s->no_diundangkan }}<br>{{ $s->tgl_diundangkan }}</td>
              <td>{{ $s->keterangan }}</td>
              <td>
                  <button class="btn btn-warning show-button editData" data-toggle="modal" data-target="#modal-tambah-edit" data-surat='@json($s)'>Ubah</button>                  
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
        {{ $sk->appends($_GET)->links() }}
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
        <h4 class="modal-title" id="modalTambahEdit">Tambah Agenda Surat Keputusan Kepala Desa</h4>
      </div>
      <form id="form_tambah_edit" enctype="multipart/form-data" role="form" method="POST">
        @csrf
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nomor SK Kades</label>
                    <input required type="text" id="no_kades" name="no_kades" class="form-control">                    
                    <input type="hidden" name="id_sk" id="id_sk">         
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Tanggal SK Kades</label>
                    <input required type="date" id="tgl_kades" name="tgl_kades" class="form-control">                                
                </div>
              </div>
            </div>          
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Tentang</label>
                    <input required type="text" id="tentang" name="tentang" class="form-control">                    
                  </div>
              </div>            
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label">Uraian Singkat</label>
                      <input required type="text" id="uraian" name="uraian" class="form-control">                    
                    </div>
                </div>            
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Nomor Diundangkan</label>
                      <input required type="text" id="no_diundangkan" name="no_diundangkan" class="form-control">                    
                    </div>
                </div>            
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Tanggal Diundangkan</label>
                    <input required type="date" id="tgl_diundangkan" name="tgl_diundangkan" class="form-control">                    
                  </div>
              </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label">Keterangan</label>
                      <input required type="text" id="keterangan" name="keterangan" class="form-control">                    
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
          Apakah Anda yakin akan menghapus item ini?
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
    //   $("#no_surat").attr("onkeyup", "cekKodeSurat(this);");
    //   $("#NomerWarning").text("");
      $("#form_tambah_edit").attr("action", '{{ URL::to("/tambah-surat-keputusan-kades") }}'); 
    });

    $('.editData').on('click', function() {
      $("#form_tambah_edit").attr("action", '{{ URL::to("/edit-surat-keputusan-kades") }}');
      $("#NomerWarning").text("");
      let surat = $(this).data('surat');          
      $("#id_sk").attr("value", surat.id);      
      $('#no_kades').val(surat.no_kades);
      $('#tgl_kades').val(surat.tgl_kades);
      $('#tentang').val(surat.tentang);    
      $('#uraian').val(surat.uraian);      
      $('#no_diundangkan').val(surat.no_diundangkan);
      $('#tgl_diundangkan').val(surat.tgl_diundangkan);
      $('#keterangan').val(surat.keterangan);  
    });    

    $('.hapusData').on('click', function() {
      var id = $(this).data('id');      
      $("#hapus_id").attr("value", id);
      $('#form-delete').attr('action', '{{ URL::to("/hapus-surat-keputusan-kades") }}');
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