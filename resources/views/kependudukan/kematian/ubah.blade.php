{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Kematian |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data Kematian Mendiang {{ $death->resident->name}}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action('Residency\DeathController@update', $death->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan kematian disini</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" name="date_of_death" value="{{ $death->date_of_death->format('Y-m-d') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Waktu Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="time" class="form-control" name="time_of_death" required value="{{ $death->time_of_death }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tempat Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <select class="form-control" title="Pilih salah satu" name="place_of_death" id="reporter_relation" required>
                            <option></option>
                            <option {{ $death->place_of_death == 'rumah_sakit' ? 'selected' : '' }} value="rumah_sakit">Rumah Sakit</option>
                            <option {{ $death->place_of_death == 'lainnya' ? 'selected' : '' }} value="lainnya">Lainnya</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Penyebab Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="cause_of_death" required value="{{ $death->cause_of_death }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Penentu Kematian <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="determinant" required>
                        <option></option>
                        <option {{ $death->determinant == 'dokter' ? 'selected' : '' }} value="dokter">Dokter</option>
                        <option {{ $death->determinant == 'perawat' ? 'selected' : '' }} value="perawat">Perawat</option>
                        <option {{ $death->determinant == 'tenaga_kesehatan' ? 'selected' : '' }} value="tenaga_kesehatan">Tenaga Kesehatan</option>
                        <option {{ $death->determinant == 'lainnya' ? 'selected' : '' }} value="lainnya">Lainnya</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Pelapor <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="reporter" required value="{{ $death->reporter }}">
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
                              <option {{ $death->reporter_relation == $item ? 'selected' : '' }} value="{{$item}}">{{ ucfirst($item) }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                    <a href="{{ action("Residency\DeathController@index") }}" class="btn btn-default">Kembali</a>
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

  function getResident() {
    var nik = $('#nik_input').val();
    if (nik) {
      $.getJSON(`${url}/penduduk/${nik}/info`, function(data) {
        if (data.length > 0) {
            $('#resident-list').empty();
            $('#resident-list').fadeIn();
            $('#resident-list').append(`<ul id="result-resident-list" class="dropdown-menu" style="display:block; position:relative">`);
            $.each(data, function(key, value) {
              $('#result-resident-list').append(`<li 
                onclick="chooseResident('${value.nik}', '${value.name}')">
                  NIK : ${value.nik} - Nama : ${value.name}
                </li>`);
            });
        }
      });
    }
  }

  function chooseResident(nik, name) {
    $('#nik').attr('value', nik);
    $('#nik_input').attr('value', `${nik} - ${name}`);
    $('#resident-list').fadeOut();
  }

  $(document).ready(function(){
    $('#nik_input').on('keyup', getResident);
  });
  </script>
@endsection