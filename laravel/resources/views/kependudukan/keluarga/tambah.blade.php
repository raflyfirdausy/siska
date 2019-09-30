{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Tambah Keluarga |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Tambah</strong> Keluarga
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url('/keluarga/tambah') }}" enctype="multipart/form-data" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan isi data diri anggota keluarga baru disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Foto</label>
                  <div class="col-md-12">
                    <input type="file" class="form-control" name="photo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="number" class="form-control" name="nik" required>
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
              <h4>Mohon isi data lengkap keluarga disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor KK <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="number" class="form-control" name="no_kk">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <textarea rows="5" class="form-control" required name="address"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RT <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rt">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RW <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rw">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="village_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="province" id="province" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($provinces as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kabupaten <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="district" id="district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kecamatan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="sub_district" id="sub_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kelurahan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="village" id="village" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("keluarga") }}" class="btn btn-default">Kembali</a>
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
</form>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <script>
    var url = "{{ URL::to('/') }}";
    var regionContainers = [
      $('#province'), $('#district'), $('#sub_district'), $('#village'),
    ];

    function emptyList(index) {
      for (var i = index; i < regionContainers.length; i++) {
        regionContainers[i].empty();
        regionContainers[i].append('<option>');
      }
    }

    $(document).ready(function() {
      $('#province').on('change', function() {
        emptyList(1);
        $('#district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#district').empty();
          }
          $('#district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#district').on('change', function() {
        emptyList(2);
        $('#sub_district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#sub_district').empty();
          }
          $('#sub_district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#sub_district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#sub_district').on('change', function() {
        emptyList(3);
        $('#village').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/village`, function(data) {
          if (data.length < 1) {
            $('#village').empty();
          }
          $('#village').append($('<option>'));
          $.each(data, function(key, val) {
            $('#village').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });
    })
  </script>
@endsection