{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Tambah Pendatang |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Tambah</strong> Pendatang
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ action('Residency\NewcomerController@store') }}" enctype="multipart/form-data" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan isi data diri pendatang disini</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-horizontal">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Foto</label>
                      <div class="col-md-12">
                        <input type="file" class="form-control" name="photo">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-12 form-label">Nomor KK <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="number" class="form-control" name="no_kk">
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
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-horizontal">
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
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Mohon isi data alamat asal pendatang disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <textarea rows="5" class="form-control" required name="from_address"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RT <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="from_rt">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RW <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="from_rw">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="from_village_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="from_province" id="from_province" class="selectpicker form-control" title="Pilih salah satu">
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
                    <select name="from_district" id="from_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kecamatan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="from_sub_district" id="from_sub_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kelurahan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="from_village" id="from_village" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
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
              <h4>Mohon isi data alamat tujuan pendatang disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <textarea rows="5" class="form-control" required name="to_address"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RT <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="to_rt">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RW <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="to_rw">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="to_village_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="to_province" id="to_province" class="selectpicker form-control" title="Pilih salah satu">
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
                    <select name="to_district" id="to_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kecamatan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="to_sub_district" id="to_sub_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kelurahan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="to_village" id="to_village" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ action('Residency\NewcomerController@index') }}" class="btn btn-default">Kembali</a>
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
    var regionContainers1 = [
      $('#from_province'), $('#from_district'), $('#from_sub_district'), $('#from_village'),
    ];

    var regionContainers2 = [
      $('#to_province'), $('#to_district'), $('#to_sub_district'), $('#to_village'),
    ];

    function emptyList(target, index) {
      for (var i = index; i < regionContainers1.length; i++) {
        if (target == 'from') {
          regionContainers1[i].empty();
          regionContainers1[i].append('<option>');
        }
        else {
          regionContainers2[i].empty();
          regionContainers2[i].append('<option>');
        }
      }
    }

    $(document).ready(function() {
      $('#from_province').on('change', function() {
        emptyList('from', 1);
        $('#from_district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#from_district').empty();
          }
          $('#from_district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#from_district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#from_district').on('change', function() {
        emptyList('from', 2);
        $('#from_sub_district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#from_sub_district').empty();
          }
          $('#from_sub_district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#from_sub_district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#from_sub_district').on('change', function() {
        emptyList('from', 3);
        $('#from_village').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/village`, function(data) {
          if (data.length < 1) {
            $('#from_village').empty();
          }
          $('#from_village').append($('<option>'));
          $.each(data, function(key, val) {
            $('#from_village').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#to_province').on('change', function() {
        emptyList('to', 1);
        $('#to_district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#to_district').empty();
          }
          $('#to_district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#to_district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#to_district').on('change', function() {
        emptyList('to', 2);
        $('#to_sub_district').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/sub`, function(data) {
          if (data.length < 1) {
            $('#to_sub_district').empty();
          }
          $('#to_sub_district').append($('<option>'));
          $.each(data, function(key, val) {
            $('#to_sub_district').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });

      $('#to_sub_district').on('change', function() {
        emptyList('to', 3);
        $('#to_village').empty();
        var id = $(this).val();
        $.getJSON(`${url}/wilayah/${id}/village`, function(data) {
          if (data.length < 1) {
            $('#to_village').empty();
          }
          $('#to_village').append($('<option>'));
          $.each(data, function(key, val) {
            $('#to_village').append($('<option>').text(val.name).attr('value', val.id));
          });
          $('.selectpicker').selectpicker('refresh');
        })
      });
    })
  </script>
@endsection