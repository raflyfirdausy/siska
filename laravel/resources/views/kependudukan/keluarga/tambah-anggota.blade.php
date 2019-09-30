{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Anggota Keluarga |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Anggota Keluarga
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("/keluarga/{$family->no_kk}/tambah-anggota") }}" enctype="multipart/form-data" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <p>Silahkan isi data diri kepala keluarga disini</p>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Hubungan <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <select class="form-control" title="Pilih salah satu" required name="relation" required>
                      <option></option>
                      <option value="kepala">Kepala</option>
                      <option value="suami">Suami</option>
                      <option value="istri">Istri</option>
                      <option value="anak">Anak</option>
                      <option value="menantu">Menantu</option>
                      <option value="cucu">Cucu</option>
                      <option value="orang_tua">Orang Tua</option>
                      <option value="mertua">Mertua</option>
                      <option value="family_lain">Family Lain</option>
                      <option value="pembantu">Pembantu</option>
                      <option value="lainnya">Lainnya</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Foto</label>
                  <div class="col-md-12">
                    <input type="file" class="form-control" name="photo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="nik" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Lengkap <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="name" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tempat Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" name="birth_place" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tanggal Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                          <input class="form-control" name="birthday" type="date" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Jenis Kelamin <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" required name="gender" required>
                          <option></option>
                          <option value="male">Laki - Laki</option>
                          <option value="female">Perempuan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Golongan Darah</label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="blood_type">
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
                      <label class="col-md-12 form-label">Kewarganegaraan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="nationality" required>
                          <option></option>
                          <option value="wni">WNI</option>
                          <option value="wna">WNA</option>
                          <option value="dwi">Dwikewarganegaraan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Agama <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="religion" required>
                          <option></option>
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
                      <label class="col-md-12 form-label">Status Perkawinan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="marriage_status" required>
                          <option></option>
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
                      <label class="col-md-12 form-label">Status Kependudukan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="resident_status" required>
                          <option></option>
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
                      <label class="col-md-12 form-label">Pendidikan Terakhir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="education_id" required>
                          <option></option>
                          @foreach ($educations as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Pekerjaan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="occupation_id" required>
                          <option></option>
                          @foreach ($occupations as $o)
                            <option value="{{ $o->id }}">{{ $o->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ url("keluarga/{$family->no_kk}") }}" class="btn btn-default">Kembali</a>
                      <button type="submit" class="btn btn-success">Simpan</button>
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
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <p>Anggota Keluarga Saat Ini</p>
            </div>
            @foreach($family->members()->canBeDisplayed()->get() as $m)
            <div class="col-md-12 member-entry">
              <div class="row member">
                <div class="col-xs-3">
                    <img src="{{$m->resident->photo ? asset($m->resident->photo) : asset('img/avatars/avatar2.png')}}" alt="{{ $m->resident->name }}" class="pull-left img-responsive">
                </div>
                <div class="col-xs-9">
                  <p class="m-t-0 member-name"><strong>{{ $m->resident->name }}</strong></p>
                  <div class="pull-left">
                    <p><i class="fa fa-user c-gray-light p-r-10"></i> {{ $m->hubungan }}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
@endsection