{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Migrasi TKI |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data Migrasi {{ $migration->resident->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action('Residency\LaborMigrationController@update', $migration->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan migrasi disini</h4>
                <div class="form-horizontal">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Negara Tujuan <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="destination_country" value="{{ $migration->destination_country }}" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Pekerjaan <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="occupation" required value="{{ $migration->occupation }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Keberangkatan <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" name="departure_date" value="{{ $migration->departure_date->format('Y-m-d') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Pulang <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" name="duration" value="{{ $migration->duration->format('Y-m-d') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Perusahaan Penyalur TKI <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select class="form-control" title="Pilih salah satu" name="labor_bureau" required>
                        <option></option>
                        @foreach ($bureaus as $b)
                        <option {{ $b->id == $migration->labor_bureau_id ? 'selected' : '' }} value="{{$b->id}}">{{ $b->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                    <a href="{{ action("Residency\LaborMigrationController@index") }}" class="btn btn-default">Kembali</a>
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