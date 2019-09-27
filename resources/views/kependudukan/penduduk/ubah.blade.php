{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Penduduk |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Penduduk : {{ $resident->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("/penduduk/{$resident->nik}/ubah") }}" enctype="multipart/form-data" method="POST">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan ubah data diri penduduk disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Hubungan <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <select class="form-control" title="Pilih salah satu" required name="relation" required>
                      <option></option>
                      <option {{ $resident->family_member->relation == 'kepala' ? 'selected' : '' }} value="kepala">Kepala</option>
                      <option {{ $resident->family_member->relation == 'suami' ? 'selected' : '' }} value="suami">Suami</option>
                      <option {{ $resident->family_member->relation == 'istri' ? 'selected' : '' }} value="istri">Istri</option>
                      <option {{ $resident->family_member->relation == 'anak' ? 'selected' : '' }} value="anak">Anak</option>
                      <option {{ $resident->family_member->relation == 'menantu' ? 'selected' : '' }} value="menantu">Menantu</option>
                      <option {{ $resident->family_member->relation == 'cucu' ? 'selected' : '' }} value="cucu">Cucu</option>
                      <option {{ $resident->family_member->relation == 'orang_tua' ? 'selected' : '' }} value="orang_tua">Orang Tua</option>
                      <option {{ $resident->family_member->relation == 'mertua' ? 'selected' : '' }} value="mertua">Mertua</option>
                      <option {{ $resident->family_member->relation == 'family_lain' ? 'selected' : '' }} value="family_lain">Family Lain</option>
                      <option {{ $resident->family_member->relation == 'pembantu' ? 'selected' : '' }} value="pembantu">Pembantu</option>
                      <option {{ $resident->family_member->relation == 'lainnya' ? 'selected' : '' }} value="lainnya">Lainnya</option>
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
                    <input type="number" value="{{ $resident->nik }}" class="form-control" name="nik" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Lengkap <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" value="{{ $resident->name }}" class="form-control" name="name" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tempat Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" value="{{ $resident->birth_place }}" class="form-control" name="birth_place" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tanggal Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                          <input class="form-control" value="{{ $resident->birthday->format('Y-m-d') }}" name="birthday" type="date" required>
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
                          <option {{ $resident->gender == 'male' ? 'selected' : '' }} value="male">Laki - Laki</option>
                          <option {{ $resident->gender == 'female' ? 'selected' : '' }} value="female">Perempuan</option>
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
                          <option {{$resident->blood_type == 'a' ? 'selected' : ''}} value="a">A</option>                       
                          <option {{$resident->blood_type == 'b' ? 'selected' : ''}} value="b">B</option>                       
                          <option {{$resident->blood_type == 'ab' ? 'selected' : ''}} value="ab">AB</option>                       
                          <option {{$resident->blood_type == 'o' ? 'selected' : ''}} value="o">O</option>                       
                          <option {{$resident->blood_type == 'a+' ? 'selected' : ''}} value="a+">A+</option>                       
                          <option {{$resident->blood_type == 'b+' ? 'selected' : ''}} value="b+">B+</option>                       
                          <option {{$resident->blood_type == 'ab+' ? 'selected' : ''}} value="ab+">AB+</option>                       
                          <option {{$resident->blood_type == 'o+' ? 'selected' : ''}} value="o+">O+</option>                       
                          <option {{$resident->blood_type == 'a-' ? 'selected' : ''}} value="a-">A-</option>                       
                          <option {{$resident->blood_type == 'b-' ? 'selected' : ''}} value="b-">B-</option>                       
                          <option {{$resident->blood_type == 'ab-' ? 'selected' : ''}} value="ab-">AB-</option>                       
                          <option {{$resident->blood_type == 'o-' ? 'selected' : ''}} value="o-">O-</option>                       
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
                          <option {{ $resident->nationality == 'wni' ? 'selected' : '' }} value="wni">WNI</option>
                          <option {{ $resident->nationality == 'wna' ? 'selected' : '' }} value="wna">WNA</option>
                          <option {{ $resident->nationality == 'dwi' ? 'selected' : '' }} value="dwi">Dwikewarganegaraan</option>
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
                          <option {{ $resident->religion == 'islam' ? 'selected' : '' }} value="islam">Islam</option>
                          <option {{ $resident->religion == 'kristen' ? 'selected' : '' }} value="kristen">Kristen</option>
                          <option {{ $resident->religion == 'katolik' ? 'selected' : '' }} value="katolik">Katolik</option>
                          <option {{ $resident->religion == 'hindu' ? 'selected' : '' }} value="hindu">Hindu</option>
                          <option {{ $resident->religion == 'buddha' ? 'selected' : '' }} value="buddha">Buddha</option>
                          <option {{ $resident->religion == 'konghucu' ? 'selected' : '' }} value="konghucu">Konghucu</option>
                          <option {{ $resident->religion == 'kepercayaan' ? 'selected' : '' }} value="kepercayaan">Kepercayaan</option>
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
                          <option {{ $resident->marriage_status == 'kawin' ? 'selected' : '' }} value="kawin">Kawin</option>
                          <option {{ $resident->marriage_status == 'belum_kawin' ? 'selected' : '' }} value="belum_kawin">Belum Kawin</option>
                          <option {{ $resident->marriage_status == 'cerai_hidup' ? 'selected' : '' }} value="cerai_hidup">Cerai Hidup</option>
                          <option {{ $resident->marriage_status == 'cerai_mati' ? 'selected' : '' }} value="cerai_mati">Cerai Mati</option>
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
                          <option {{ $resident->resident_status == 'asli'  ? 'selected' : '' }} value="asli">Asli</option>
                          <option {{ $resident->resident_status == 'pendatang'  ? 'selected' : '' }} value="pendatang">Pendatang</option>
                          <option {{ $resident->resident_status == 'pindah'  ? 'selected' : '' }} value="pindah">Pindahan</option>
                          <option {{ $resident->resident_status == 'sementara'  ? 'selected' : '' }} value="sementara">Sementara</option>
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
                            <option {{ $resident->education->id == $e->id ? 'selected' : '' }} value="{{ $e->id }}">{{ $e->name }}</option>
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
                            <option {{ $resident->occupation->id == $o->id ? 'selected' : '' }} value="{{ $o->id }}">{{ $o->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ url("penduduk/$resident->nik") }}" class="btn btn-default">Kembali</a>
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
  </div>
</form>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <script>
  </script>
@endsection