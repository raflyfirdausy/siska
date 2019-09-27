{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Ubah Kelahiran |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Ubah</strong> Data Kelahiran {{ $birth->resident->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ action('Residency\BirthController@update', $birth->id) }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan ubah data diri bayi disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="nik" value="{{ $birth->resident->nik }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Lengkap <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="name" required value="{{ $birth->resident->name }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tempat Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" name="place_of_birth" required value="{{ $birth->place_of_birth }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tanggal Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                          <input class="form-control" name="date_of_birth" type="date" required value="{{ $birth->date_of_birth->format('Y-m-d') }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Waktu Lahir <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input class="form-control" name="time_of_birth" type="time" required value="{{ $birth->time_of_birth }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Jenis Kelamin <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" required name="gender" required>
                          <option></option>
                          <option {{ $birth->resident->gender == 'male' ? 'selected' : ''}} value="male">Laki - Laki</option>
                          <option {{ $birth->resident->gender == 'female' ? 'selected' : ''}} value="female">Perempuan</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Golongan Darah</label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="blood_type">
                          <option></option>
                          <option>-</option>
                          <option {{$birth->resident->blood_type == 'a' ? 'selected' : ''}} value="a">A</option>                       
                          <option {{$birth->resident->blood_type == 'b' ? 'selected' : ''}} value="b">B</option>                       
                          <option {{$birth->resident->blood_type == 'ab' ? 'selected' : ''}} value="ab">AB</option>                       
                          <option {{$birth->resident->blood_type == 'o' ? 'selected' : ''}} value="o">O</option>                       
                          <option {{$birth->resident->blood_type == 'a+' ? 'selected' : ''}} value="a+">A+</option>                       
                          <option {{$birth->resident->blood_type == 'b+' ? 'selected' : ''}} value="b+">B+</option>                       
                          <option {{$birth->resident->blood_type == 'ab+' ? 'selected' : ''}} value="ab+">AB+</option>                       
                          <option {{$birth->resident->blood_type == 'o+' ? 'selected' : ''}} value="o+">O+</option>                       
                          <option {{$birth->resident->blood_type == 'a-' ? 'selected' : ''}} value="a-">A-</option>                       
                          <option {{$birth->resident->blood_type == 'b-' ? 'selected' : ''}} value="b-">B-</option>                       
                          <option {{$birth->resident->blood_type == 'ab-' ? 'selected' : ''}} value="ab-">AB-</option>                       
                          <option {{$birth->resident->blood_type == 'o-' ? 'selected' : ''}} value="o-">O-</option>                        
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Agama</label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="religion">
                          <option></option>
                          <option {{ $birth->resident->religion == 'islam' ? 'selected' : '' }} value="islam">Islam</option>
                          <option {{ $birth->resident->religion == 'kristen' ? 'selected' : '' }} value="kristen">Kristen</option>
                          <option {{ $birth->resident->religion == 'katolik' ? 'selected' : '' }} value="katolik">Katolik</option>
                          <option {{ $birth->resident->religion == 'hindu' ? 'selected' : '' }} value="hindu">Hindu</option>
                          <option {{ $birth->resident->religion == 'buddha' ? 'selected' : '' }} value="buddha">Buddha</option>
                          <option {{ $birth->resident->religion == 'konghucu' ? 'selected' : '' }} value="konghucu">Konghucu</option>
                          <option {{ $birth->resident->religion == 'kepercayaan' ? 'selected' : '' }} value="kepercayaan">Kepercayaan</option>
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
              <h4>Silahkan ubah keterangan keluarga disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor KK <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" name="no_kk" id="no_kk" required autocomplete="false" value="{{ $birth->family->no_kk }}">
                    <div id="family-list"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK Ayah </span></label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" id="father" autocomplete="false" value="{{ $birth->father->nik . ' - ' . $birth->father->name }}">
                    <div id="father-list"></div>
                    <input type="hidden" name="father_nik" id="father_nik" value="{{ $birth->father->nik }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK Ibu </span></label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" id="mother" autocomplete="false" value="{{ $birth->mother->nik . ' - ' . $birth->mother->name }}">
                    <div id="mother-list"></div>
                    <input type="hidden" name="mother_nik" id="mother_nik" value="{{ $birth->mother->nik }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Anak Ke </span></label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" name="child_number" id="child_number" value="{{ $birth->child_number }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tinggi (cm) <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input class="form-control" name="height" type="number" required value="{{ $birth->height }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Berat (kg) <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input class="form-control" name="weight" type="number" required value="{{ $birth->weight }}">
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
              <h4>Silahkan ubah keterangan kelahiran disini</h4>
              <div class="form-horizontal">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Tempat Persalinan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="labor_place" id="labor_place" required>
                          <option></option>
                          <option {{ $birth->labor_place == 'rumah_bersalin' ? 'selected' : '' }} value="rumah_bersalin">Rumah Bersalin</option>
                          <option {{ $birth->labor_place == 'lainnya' ? 'selected' : '' }} value="lainya">Lainnya</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Pembantu Persalinan <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="labor_helper" id="labor_helper" required>
                          <option></option>
                          <option {{ $birth->labor_helper == 'dokter' ? 'selected' : '' }} value="dokter">Dokter</option>
                          <option {{ $birth->labor_helper == 'bidan' ? 'selected' : '' }} value="bidan">Bidan</option>
                          <option {{ $birth->labor_helper == 'dukun' ? 'selected' : '' }} value="dukun">Dukun</option>
                          <option {{ $birth->labor_helper == 'lainnya' ? 'selected' : '' }} value="lainya">Lainnya</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Pelapor <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" name="reporter" required value="{{ $birth->reporter }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">Hubungan Pelapor <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <select class="form-control" title="Pilih salah satu" name="reporter_relation" id="reporter_relation" required>
                          <option></option>
                          @foreach (['ayah', 'ibu', 'kakak', 'paman', 'bibi', 'kakek', 'nenek', 'keponakan', 'sepupu', 'kerabat'] as $item)
                            <option value="{{$item}}" {{ $birth->reporter_relation == $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Saksi 1 <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="first_witness" required value="{{ $birth->first_witness }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Saksi 2 <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="second_witness" required value="{{ $birth->second_witness }}">
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                  <a href="{{ action("Residency\BirthController@index") }}" class="btn btn-default">Kembali</a>
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

@section('page-footers')
  <script>
    var url = "{{ URL::to('/') }}";

    function getResident(input, nik, target, inputTarget) {
      var nokk = $('#no_kk').val();
      if (nik) {
        $.getJSON(`${url}/penduduk/${nik}/info?no_kk=${nokk ? nokk : ''}`, function(data) {
          if (data.length > 0) {
              $('#' + target).empty();
              $('#' + target).fadeIn();
              $('#' + target).append(`<ul id="result-${target}" class="dropdown-menu" style="display:block; position:relative">`);
              $.each(data, function(key, value) {
                $('#result-' + target).append(`<li 
                  onclick="chooseResident('${input}', '${inputTarget}', '${value.nik}', '${value.name}', '${target}')">
                    NIK : ${value.nik} - Nama : ${value.name}
                  </li>`);
              });
          }
        });
      }
    }

    function chooseResident(input, target, nik, name, resultWrapper) {
      $(target).attr('value', nik);
      $(input).attr('value', `${nik} - ${name}`);
      $('#' + resultWrapper).fadeOut();
    }
    
    function getFamily() {
      var kk = $('#no_kk').val();
      if (kk) {
        $.getJSON(`${url}/keluarga/${kk}/kepala`, function(data) {
          if (data.length > 0) {
            $('#family-list').empty();
            $('#family-list').fadeIn();
            $('#family-list').append('<ul id="result-family-list" class="dropdown-menu" style="display:block; position:relative">');
            $.each(data, function(key, value) {
              $('#result-family-list').append(`<li 
                onclick="chooseFamily('${value.no_kk}')">
                  Nomor KK : ${value.no_kk} - Kepala Keluarga : ${value.head.name}
                </li>`);
            });
          }
        });
      }
    }

    function chooseFamily(kk) {
      $('#no_kk').attr('value', kk);
      $('#family-list').fadeOut();
    }

    $(document).ready(function() {
      $('#father').on('keyup', function() {
        var nik = $(this).val();
        getResident('#father', nik, 'father-list', '#father_nik');
      });
      
      $('#mother').on('keyup', function() {
        var nik = $(this).val();
        getResident('#mother', nik, 'mother-list', '#mother_nik');
      });

      $('#no_kk').on('keyup', getFamily)
    });
  </script>
@endsection