{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Kematian |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Data Kematian
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action('Residency\DeathController@store') }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan isi keterangan kematian disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" id="nik_input" required autocomplete="false">
                      <div id="resident-list"></div>
                      <input type="hidden" name="nik" id="nik" value="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" name="date_of_death">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Waktu Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="time" class="form-control" name="time_of_death" required>
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
                            <option value="rumah_sakit">Rumah Sakit</option>
                            <option value="lainnya">Lainnya</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Penyebab Kematian <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="cause_of_death" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Penentu Kematian <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="determinant" required>
                        <option></option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="tenaga_kesehatan">Tenaga Kesehatan</option>
                        <option value="lainnya">Lainnya</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Pelapor <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="reporter" required>
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
                              <option value="{{$item}}">{{ ucfirst($item) }}</option>
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