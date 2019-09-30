{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Lihat Penduduk |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Lihat</strong> Penduduk : {{ $data->content[0]->NAMA_LGKP }}
@endsection


{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <h4>Data Diri Penduduk</h4>
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-md-12 form-label">NIK</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="nik" value="{{ $data->content[0]->NIK }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Nama Lengkap</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" value="{{ $data->content[0]->NAMA_LGKP }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Hubungan Dengan Keluarga</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" value="{{ $data->content[0]->STAT_HBKEL }}" disabled>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Tempat Lahir</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->TMPT_LHR }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Tanggal Lahir</label>
                    <input type="text" class="form-control" value="{{ $data->content[0]->TGL_LHR }}" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jenis Kelamin</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->JENIS_KLMIN }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Golongan Darah</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->GOL_DARAH }}" disabled>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kewarganegaraan</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="BELUM" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Agama</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->AGAMA }}" disabled>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Status Perkawinan</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->STATUS_KAWIN }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- <div class="form-group">
                    <label class="col-md-12 form-label">Status Kependudukan</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="TIDAK DIKETAHUI" disabled>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Pendidikan Terakhir</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->PDDK_AKH }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Pekerjaan</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="{{ $data->content[0]->JENIS_PKRJN }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url('modul-kependudukan') }}" class="btn btn-default">Kembali</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default d-inline">
      <div class="panel-body">
        <div class="row">
          <div class="container">
            <h3>Cetak Surat</h3>
            <p>Silahkan pilih surat yang akan dicetak</p>                                         
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Pengaturan Penduduk
                <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalBiodata" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Cetak Biodata</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalketpengantar" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Pengantar</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalketdomisili" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Domisili</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalskck" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Catatan Kepolisian</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalsktm" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Tidak Mampu</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalkehilangan" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Kehilangan</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalkeramaian" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Izin Keramaian</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalusaha" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Usaha</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalketpddk" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan Penduduk</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalktpproses" tabindex="-1"><i class="fa fa-print">&nbsp;</i> Surat Keterangan KTP Dalam Proses</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalakta" tabindex="-1"> <i class="fa fa-print">&nbsp;</i> Surat Permohonan Akta</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalcerai" tabindex="-1"> <i class="fa fa-print">&nbsp;</i> Surat Permohonan Cerai</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modaldupkelahiran" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Permohonan Duplikat Kelahiran</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modaldupnikah" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Permohonan Duplikat Surat Nikah</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalpermohonankk" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Permohonan Kartu Keluarga</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalpermohonanpkk" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Permohonan Perubahan Kartu Keluarga</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalperakta" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Pernyataan Akta</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#modalsporadik" tabindex="-1"> <i class="fa fa-print">&nbsp;</i>Surat Pernyataan Penguasaan Fisik Bidang Tanah (SPORADIK)</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus berkas <span id="nama-berkas">-</span>?
        </div>
        <div class="modal-footer">
          <form action="-" id="form-delete" method="POST">
            @csrf
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!--Modal Biodata -->
<div class="modal fade" id="modalBiodata" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Biodata Penduduk</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <div class="row">
              <div class="col-md-4">
                <input type="varchar" name="no_surat" class="form-control">
              </div>
              <div class="col-md-4">
                <input type="varchar" name="no_surat2" class="form-control">
              </div>
              <div class="col-md-4">
                <input type="varchar" name="no_surat3" class="form-control">
              </div>
            </div>
          </div>
            <div class="form-group">
              <label class="form-label">NIK Ayah </label>
              <input class="form-control" name="n1k" id="n1k" type="text" autocomplete="false">
              <div id="recommendation-list-ayah" style="position: absolute"></div>
            </div>
            <div class="form-group">
              <label class="form-label">Nama Ayah</label>
              <input class="form-control" name="b4pac" id="b4pac" type="text" readonly>
            </div>
            <div class="form-group">
              <label class="form-label">NIK Ibu </label>
              <input class="form-control" name="n1c" id="n1c" type="text" autocomplete="false">
              <div id="recommendation-list-ibu" style="position: absolute"></div>
            </div>
            <div class="form-group">
              <label class="form-label">Nama Ibu</label>
              <input class="form-control" name="ib0" id="ib0" type="text" readonly>
            </div>
          <div class="form-group">
            <label class="form-label">Alamat Sebelumnya </label>
            <input type="varchar" name="almtsebelum" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Akta Kelahiran </label>
            <input type="varchar" name="no_akta_lahir" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Paspor </label>
            <input type="varchar" name="no_paspor" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Berakhir Paspor </label>
            <input type="date" name="end_paspor" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Akta Perkawinan </label>
            <input type="varchar" name="no_akta_kawin" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Akta Perkawinan </label>
            <input type="date" name="tgl_akta_kawin" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Akta Perceraian </label>
            <input type="varchar" name="no_akta_cerai" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Perceraian </label>
            <input type="date" name="tgl_cerai" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Kelanian Fisik/Mental </label>
            <input type="text" name="cacat" value="-" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
  
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Biodata --}}

<!--Modal Ket Pengantar -->
<div class="modal fade" id="modalketpengantar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="GET" action="{{ url('/') }}/modul-kependudukan/cetak-ket-pengantar/{{ $data->content[0]->NIK }}">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Keterangan Pengantar</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label class="form-label">Nomor Surat </label>
              <input type="text" name="no_surat" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label">Keperluan </label>
              <input type="text" name="keperluan" class="form-control">
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="form-label">Mulai Berlaku</label>
                  <input type="date" name="mulai_berlaku" class="form-control">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="form-label">Tanggal Akhir</label>
                  <input type="date" name="tgl_akhir" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Pamong </label>
              <select name="pamong_id" required class="form-control" title="Pilih salah satu">
                <option></option>
                @foreach($officials as $o)
                <option value="{{ $o->id }}">{{ $o->name }} ({{ $o->jabatan }})</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Cetak</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal ket Domisili --}}
<div class="modal fade" id="modalketdomisili" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Keterangan Domisili</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keperluan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Ket Domisili --}}
{{-- Modal SKCK --}}
<div class="modal fade" id="modalskck" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak SKCK</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keperluan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal SKCK --}}
{{-- Modal SKTM --}}
<div class="modal fade" id="modalsktm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak SKTM</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keperluan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
              
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal SKTM --}}
{{-- Modal Ket Kehilangan --}}
<div class="modal fade" id="modalkehilangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Kehilangan</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Barang </label>
            <input type="text" name="barang" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Rincian Barang </label>
            <input type="text" name="rincian" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Keterangan </label>
            <input type="text" name="keterangan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
              
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Ketkehilangan --}}
{{-- Modal Izin Keramaian --}}
<div class="modal fade" id="modalkeramaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Izin Keramaian</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Jenis Keramaian </label>
            <input type="text" name="keramaian" class="form-control">
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Dari </label>
                <input type="date" name="dari" class="form-control">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Sampai </label>
                <input type="date" name="sampai" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keterangan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Keramaian --}}
{{-- Modal ket usaha --}}
<div class="modal fade" id="modalusaha" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Keterangan Usaha</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Usaha </label>
            <input type="text" name="usaha" class="form-control">
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Dari </label>
                <input type="date" name="dari" class="form-control">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Sampai </label>
                <input type="date" name="sampai" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keterangan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
             
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal ket usaha --}}
{{-- Modal ket penduduk --}}
<div class="modal fade" id="modalketpddk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Keterangan Penduduk</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Keperluan </label>
            <input type="text" name="keterangan" class="form-control">
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Dari </label>
                <input type="date" name="dari" class="form-control">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Berlaku Sampai </label>
                <input type="date" name="sampai" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal ket penduduk --}}
<!--Modal KTP dalam Proses -->
<div class="modal fade" id="modalktpproses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Keterangan KTP Dalam Proses</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal ktp dalam proses --}}
{{--MODAL SURAT SPORADIK--}}
<div class="modal fade" id="modalsporadik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Pernyataan Sporadik</h4>
      </div>
      <form  method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">NIB </label>
            <input type="number" name="nib" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Status Tanah </label>
            <input type="text" name="statustanah" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Dipergunakan Untuk </label>
            <input type="text" name="dipergunakanuntuk" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Luas Hak Tanah </label>
            <input type="number" name="luas" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Tanah Diperoleh Dari </label>
            <input type="text" name="perolehdari" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Diperoleh Pada Tahun </label>
            <input type="number" name="perolehtahun" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Diperoleh Dengan Jalan </label>
            <input type="text" name="perolehjalan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Batas Tanah Utara </label>
            <input type="text" name="utara" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Batas Tanah Timur </label>
            <input type="text" name="timur" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Batas Tanah Selatan </label>
            <input type="text" name="selatan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Batas Tanah Barat </label>
            <input type="text" name="barat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Saksi 1 </label>
            <input type="text" name="namesaksi1" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Umur Saksi 1 </label>
            <input type="text" name="umursaksi1" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pekerjaan Saksi 1 </label>
            <input type="text" name="kerjaansaksi1" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Saksi 1 </label>
            <input type="text" name="alamatsaksi1" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Saksi 2 </label>
            <input type="text" name="namesaksi2" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Umur Saksi 2 </label>
            <input type="text" name="umursaksi2" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pekerjaan Saksi 2 </label>
            <input type="text" name="kerjaansaksi2" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Saksi 2 </label>
            <input type="text" name="alamatsaksi2" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Permohonan Sporadik --}}
{{-- Modal dup nikah --}}
<div class="modal fade" id="modaldupnikah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Permohonan Duplikat Surat Nikah</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal Nikah </label>
            <input type="date" name="tgl_nikah" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Pasangan </label>
            <input type="text" name="nama_pasangan" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal dup nikah --}}
{{-- Modal permohonan kk --}}
<div class="modal fade" id="modalpermohonankk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Permohonan Kartu Keluarga</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal permohonan kk --}}
{{-- Modal permohonan kk --}}
<div class="modal fade" id="modalpermohonanpkk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Permohonan Perubahan Kartu Keluarga</h4>
      </div>
      <form method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal permohonan kk --}}
{{-- Modal Permohonan Akta --}}
<div class="modal fade" id="modalakta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Permohonan Akta</h4>
      </div>
      <form  method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Nama Anak </label>
            <input type="text" name="namanak" class="form-control">
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tmptlahir">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgllahir">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Hari Lahir </label>
            <select class="form-control" title="Pilih salah satu" required name="hari" required>
              <option></option>
              <option value="Senin">Senin</option>
              <option value="Selasa">Selasa</option>
              <option value="Rabu">Rabu</option>
              <option value="Kamis">Kamis</option>
              <option value="Jumat">Jumat</option>
              <option value="Sabtu">Sabtu</option>
              <option value="Minggu">Minggu</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Anak </label>
            <input type="text" name="formalmat" class="form-control">
          </div>
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Nama Ayah </label>
                <input type="text" name="namayah" class="form-control">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label class="form-label">Nama Ibu </label>
                <input type="text" name="namibu" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Orang Tua </label>
            <input type="text" name="almatortu" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Permohonan Akta --}}
{{-- Modal Permohonan Cerai --}}
<div class="modal fade" id="modalcerai" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Permohonan Cerai</h4>
      </div>
      <form  method="GET" action="#">
      <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Nomor Surat </label>
            <input type="number" name="no_surat" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">NIK Istri </label>
            <input class="form-control" name="nik_istri" id="nik_istri" type="text" autocomplete="false">
            <div id="recommendation-list-istri" style="position: absolute"></div>
          </div>
          <div class="form-group">
            <label class="form-label">Nama Istri </label>
            <input class="form-control" id="nama_istri" type="text" readonly autocomplete="false">
          </div>
          <div class="form-group">
            <label class="form-label">Penyebab Perceraian </label>
            <input type="text" name="sebab" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label">Pamong </label>
            <select name="pamong_id" required class="form-control" title="Pilih salah satu">
              <option></option>
            
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cetak</button>
      </div>
      </form>
    </div>
  </div>
</div>
{{-- End Modal Permohonan Cerai --}}
<!--Modal Biodata -->
<div class="modal fade" id="modaldupkelahiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Permohonan Duplikat Kelahiran</h4>
      </div>
      <form method="GET" action="#">
        <div class="modal-body">
            <div class="form-group">
              <label class="form-label">Nomor Surat </label>
              <input type="text" name="no_surat" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label">NIK Anak </label>
              <input class="form-control" name="nik_anak" id="dup-lahir-nik-anak" type="text" autocomplete="false">
              <div id="recommendation-list-dup-lahir-anak" style="position: absolute"></div>
            </div>
            <div class="form-group">
              <label class="form-label">Nama Anak</label>
              <input class="form-control" name="nama_anak" id="dup-lahir-nama-anak" type="text" readonly>
            </div>
            <div class="form-group">
              <label class="form-label">NIK Ayah </label>
              <input class="form-control" name="nik_ayah" id="dup-lahir-nik-ayah" type="text" autocomplete="false">
              <div id="recommendation-list-dup-lahir-ayah" style="position: absolute"></div>
            </div>
            <div class="form-group">
              <label class="form-label">Nama Ayah</label>
              <input class="form-control" name="nama_ayah" id="dup-lahir-nama-ayah" type="text" readonly>
            </div>
            <div class="form-group">
              <label class="form-label">NIK Ibu </label>
              <input class="form-control" name="nik_ibu" id="dup-lahir-nik-ibu" type="text" autocomplete="false">
              <div id="recommendation-list-dup-lahir-ibu" style="position: absolute"></div>
            </div>
            <div class="form-group">
              <label class="form-label">Nama Ibu</label>
              <input class="form-control" name="nama_ibu" id="dup-lahir-nama-ibu" type="text" readonly>
            </div>
            <div class="form-group">
              <label class="form-label">Tempat Lahir</label>
              <input class="form-control" name="tempat_lahir"type="text">
            </div>
            <div class="row">
              <div class="col-xs-6">
                  <div class="form-group">
                    <label class="form-label">Hari Lahir </label>
                    <select class="form-control" title="Pilih salah satu" required name="hari" required>
                      <option></option>
                      <option value="Senin">Senin</option>
                      <option value="Selasa">Selasa</option>
                      <option value="Rabu">Rabu</option>
                      <option value="Kamis">Kamis</option>
                      <option value="Jumat">Jumat</option>
                      <option value="Sabtu">Sabtu</option>
                      <option value="Minggu">Minggu</option>
                    </select>
                  </div>
              </div>
              <div class="col-xs-6">
                <label class="form-label">Jam Lahir</label>
                <input class="form-control" name="jam" type="time">
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Pamong </label>
              <select name="pamong_id" required class="form-control" title="Pilih salah satu">
                <option></option>
                
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Cetak</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalperakta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalCenterTitle">Cetak Surat Pernyataan Akta</h4>
        </div>
        <form method="GET" action="#">
          <div class="modal-body">
              <div class="form-group">
                <label class="form-label">Nomor Surat </label>
                <input type="text" name="no_surat" class="form-control">
              </div>
              <div class="form-group">
                <label class="form-label">NIK Ayah </label>
                <input class="form-control" name="nik_ayah" id="pernyataan-akta-nik-ayah" type="text" autocomplete="false">
                <div id="recommendation-list-pernyataan-akta-ayah" style="position: absolute"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Ayah</label>
                <input class="form-control" name="nama_ayah" id="pernyataan-akta-nama-ayah" type="text" readonly>
              </div>
              <div class="form-group">
                <label class="form-label">NIK Ibu </label>
                <input class="form-control" name="nik_ibu" id="pernyataan-akta-nik-ibu" type="text" autocomplete="false">
                <div id="recommendation-list-pernyataan-akta-ibu" style="position: absolute"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Nama Ibu</label>
                <input class="form-control" name="nama_ibu" id="pernyataan-akta-nama-ibu" type="text" readonly>
              </div>
              <div class="form-group">
                <label class="form-label">Pamong </label>
                <select name="pamong_id" required class="form-control" title="Pilih salah satu">
                  <option></option>
                  
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Cetak</button>
          </div>
        </form>
      </div>
    </div>
  </div>
{{-- End Modal Biodata --}}
  <script>

    var url = "{{ URL::to('/') }}";
    
    function chooseResident(nik, name) {
      $('#n1k').attr('value', nik);
      $('#b4pac').attr('value', name);
      $('#recommendation-list-ayah').fadeOut();
    }
  
    function getResident() {
      var nik = $('#n1k').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info', function(data) {
          if (data.length > 0) {
              $('#recommendation-list-ayah').empty();
              $('#recommendation-list-ayah').fadeIn();
              $('#recommendation-list-ayah').append('<ul id="recommendation" class="dropdown-menu" style="display:block; position:relative">');
              $.each(data, function(key, value) {
                $('#recommendation').append(`<li 
                  onclick="chooseResident('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }

    function chooseIbu2(nik, name) {
        $('#n1c').attr('value', nik);
        $('#ib0').attr('value', name);
        $('#recommendation-list-ibu').fadeOut();
      }
    
      function getIbu2() {
        var nik = $('#n1c').val();
        if (nik) {
          $.getJSON(url + '/penduduk/' + nik + '/info', function(data) {
            if (data.length > 0) {
                $('#recommendation-list-ibu').empty();
                $('#recommendation-list-ibu').fadeIn();
                $('#recommendation-list-ibu').append('<ul id="recommendation-ibu2" class="dropdown-menu" style="display:block; position:relative">');
                $.each(data, function(key, value) {
                  $('#recommendation-ibu2').append(`<li 
                    onclick="chooseIbu2('${value.nik}', '${value.name}')">
                      NIK : ${value.nik} - Nama : ${value.name}
                    </li>`);
                });
            }
          });
        }
      }
    function chooseIstri(nik, name) {
      $('#nik_istri').attr('value', nik);
      $('#nama_istri').attr('value', name);
      $('#recommendation-list-istri').fadeOut();
    }
  
    function getIstri() {
      var nik = $('#nik_istri').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info?wanita=1', function(data) {
          if (data.length > 0) {
              $('#recommendation-list-istri').empty();
              $('#recommendation-list-istri').fadeIn();
              $('#recommendation-list-istri').append('<ul id="recommendation-istri" class="dropdown-menu" style="display:block; position:relative">');
              $.each(data, function(key, value) {
                $('#recommendation-istri').append(`<li 
                  onclick="chooseIstri('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }


    function chooseIbu(nik, name) {
      $('#dup-lahir-nik-ibu').attr('value', nik);
      $('#dup-lahir-nama-ibu').attr('value', name);
      $('#recommendation-list-dup-lahir-ibu').fadeOut();
    }
    function chooseAyah(nik, name) {
      $('#dup-lahir-nik-ayah').attr('value', nik);
      $('#dup-lahir-nama-ayah').attr('value', name);
      $('#recommendation-list-dup-lahir-ayah').fadeOut();
    }
    function chooseAnak(nik, name) {
      $('#dup-lahir-nik-anak').attr('value', nik);
      $('#dup-lahir-nama-anak').attr('value', name);
      $('#recommendation-list-dup-lahir-anak').fadeOut();
    }
  
    function getIbu() {
      var nik = $('#dup-lahir-nik-ibu').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info?wanita=1', function(data) {
          if (data.length > 0) {
              $('#recommendation-list-dup-lahir-ibu').empty();
              $('#recommendation-list-dup-lahir-ibu').fadeIn();
              $('#recommendation-list-dup-lahir-ibu').append('<ul id="recommendation-ibu" class="dropdown-menu" style="display:block; position:relative">');
              $.each(data, function(key, value) {
                $('#recommendation-ibu').append(`<li 
                  onclick="chooseIbu('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }
    function getAyah() {
      var nik = $('#dup-lahir-nik-ayah').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info?pria=1', function(data) {
          if (data.length > 0) {
              $('#recommendation-list-dup-lahir-ayah').empty();
              $('#recommendation-list-dup-lahir-ayah').fadeIn();
              $('#recommendation-list-dup-lahir-ayah').append('<ul id="recommendation-ayah" class="dropdown-menu" style="display:block; position:relative">');
              $.each(data, function(key, value) {
                $('#recommendation-ayah').append(`<li 
                  onclick="chooseAyah('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }
    function getAnak() {
      var nik = $('#dup-lahir-nik-anak').val();
      if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info', function(data) {
          if (data.length > 0) {
              $('#recommendation-list-dup-lahir-anak').empty();
              $('#recommendation-list-dup-lahir-anak').fadeIn();
              $('#recommendation-list-dup-lahir-anak').append('<ul id="recommendation-anak" class="dropdown-menu" style="display:block; position:relative">');
              $.each(data, function(key, value) {
                $('#recommendation-anak').append(`<li 
                  onclick="chooseAnak('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }

    function chooseIbuAkta(nik, name) {
        $('#pernyataan-akta-nik-ibu').attr('value', nik);
        $('#pernyataan-akta-nama-ibu').attr('value', name);
        $('#recommendation-list-pernyataan-akta-ibu').fadeOut();
    }
    function chooseAyahAkta(nik, name) {
        $('#pernyataan-akta-nik-ayah').attr('value', nik);
        $('#pernyataan-akta-nama-ayah').attr('value', name);
        $('#recommendation-list-pernyataan-akta-ayah').fadeOut();
    }

    function getIbuAkta() {
        var nik = $('#pernyataan-akta-nik-ibu').val();
        if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info?wanita=1', function(data) {
            if (data.length > 0) {
                $('#recommendation-list-pernyataan-akta-ibu').empty();
                $('#recommendation-list-pernyataan-akta-ibu').fadeIn();
                $('#recommendation-list-pernyataan-akta-ibu').append('<ul id="recommendation-ibu-akta" class="dropdown-menu" style="display:block; position:relative">');
                $.each(data, function(key, value) {
                $('#recommendation-ibu-akta').append(`<li 
                    onclick="chooseIbuAkta('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                    </li>`);
                });
            }
        });
        }
    }
    function getAyahAkta() {
        var nik = $('#pernyataan-akta-nik-ayah').val();
        console.log(nik);
        if (nik) {
        $.getJSON(url + '/penduduk/' + nik + '/info?pria=1', function(data) {
            if (data.length > 0) {
                $('#recommendation-list-pernyataan-akta-ayah').empty();
                $('#recommendation-list-pernyataan-akta-ayah').fadeIn();
                $('#recommendation-list-pernyataan-akta-ayah').append('<ul id="recommendation-ayah-akta" class="dropdown-menu" style="display:block; position:relative">');
                $.each(data, function(key, value) {
                $('#recommendation-ayah-akta').append(`<li 
                    onclick="chooseAyahAkta('${value.nik}', '${value.name}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                    </li>`);
                });
            }
        });
        }
    }
    
    $(document).ready(function() {
      $('#n1k').on('keyup', getResident);
      $('#nik_istri').on('keyup', getIstri);
      $('#n1c').on('keyup', getIbu2);
      $('#dup-lahir-nik-ibu').on('keyup', getIbu);
      $('#dup-lahir-nik-ayah').on('keyup', getAyah);
      $('#dup-lahir-nik-anak').on('keyup', getAnak);
      $('#pernyataan-akta-nik-ibu').on('keyup', getIbuAkta);
      $('#pernyataan-akta-nik-ayah').on('keyup', getAyahAkta);
    });
    </script>
{{-- End Bio Penduduk --}}
@endsection