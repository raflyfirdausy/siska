{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Form Audit Kemiskinan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Audit</strong> Kemiskinan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("audit-kemiskinan/tambah") }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <h4>Silahkan isi NIK penduduk yang akan diaudit disini</h4>
            <div class="form-group">
              <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
              <div class="col-md-10">
                <input class="form-control" name="nik" id="nik" type="text" required>
                <div id="recommendation-list"></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-12 form-label">Nama</label>
              <div class="col-md-10">
                <input class="form-control" id="nama" type="text" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
      <div class="col-md-12">
        <h4>Silahkan isi pertanyaan audit kemiskinan baru disini</h4>
        <div class="form-horizontal m-t-30">
        @foreach ($questions as $q)
        <div class="form-group">
          <label class="form-label">{{$q}}</label>
          <div class="col-md-10">
            <ul class="list col-md-6">
              <li>
                <label>
                  <input type="radio" name="answer-{{$loop->iteration}}" value="1">Iya
                </label>
                <label>
                  <input type="radio" name="answer-{{$loop->iteration}}" value="0" checked>Tidak
                </label>
              </li>
            </ul>
          </div>
        </div>
        @endforeach
        <div class="col-sm-9 col-sm-offset-3">
          <div class="pull-right">
          <a href="{{ url("kemiskinan") }}" class="btn btn-default">Kembali</a>
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
  function chooseResident(nik, name) {
    $('#nik').attr('value', nik);
    $('#nama').attr('value', name);
    $('#recommendation-list').fadeOut();
  }

  function getResident() {
    var nik = $('#nik').val();
    if (nik) {
      $.getJSON(url + '/penduduk/' + nik + '/info', function(data) {
        if (data.length > 0) {
            $('#recommendation-list').empty();
            $('#recommendation-list').fadeIn();
            $('#recommendation-list').append('<ul id="recommendation" class="dropdown-menu" style="display:block; position:relative">');
            $.each(data, function(key, value) {
              $('#recommendation').append(`<li 
                onclick="chooseResident('${value.nik}', '${value.name}')">
                  NIK : ${value.nik} - Nama : ${value.name}
                </li>`);
            });
        }
        else {
          transferFields[1].empty();
        }
      });
    }
  }
  $(document).ready(function() {
    $('#nik').on('keyup', getResident);
  });
</script>
@endsection
