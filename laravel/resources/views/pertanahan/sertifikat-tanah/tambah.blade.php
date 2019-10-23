{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
Tambah Sertifikat Tanah |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')

@endsection

{{-- Judul halaman --}}
@section('page-title')
<strong>Tambah</strong> Sertifikat Tanah
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ action('Estate\LandCertificateController@store') }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan isi data sertifikat disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK Pemilik Saat Ini <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input class="form-control" type="text" id="current-owner-nik-input" autocomplete="false">
                    <div id="current-owner-nik-list"></div>
                    <input type="hidden" name="current_owner_nik" id="current_owner_nik" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor Sertifikat <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="number" required>
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 form-label">Foto Sertifikat Tanah <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="file" class="form-control" name="photo">
                    </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ action('Estate\LandCertificateController@index') }}" class="btn btn-default">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
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
              <div class="row">
                <div class="col-md-8">
                  <h4>Silahkan isi data pemilik sebelumnya disini (jika ada)</h4>
                </div>
                <div class="col-md-4">
                  <button type="button" id="add-past-owner-button" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Tambah</button>
                </div>
              </div>
              <div class="form-horizontal" id="past-owners-wrapper">
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
  var idCounter = 0;

  function getResident(input, nik, target, inputTarget) {
    if (nik) {
      $.getJSON(`${url}/penduduk/${nik}/info`, function(data) {
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

  $(document).ready(function() {
    $('#current-owner-nik-input').on('keyup', function() {
      var nik = $(this).val();
      getResident('#current-owner-nik-input', nik, 'current-owner-nik-list', '#current_owner_nik');
    })

    $('#add-past-owner-button').on('click', function() {
      (() => {
        const currentId = idCounter;
        const pastOwnersWrapper = $('#past-owners-wrapper');
        pastOwnersWrapper.append(`
            <div class="row" id="past-owner-input-${currentId}">
              <div class="col-md-7">
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" id="past-owner-nik-input-${currentId}">
                    <div id="past-owner-nik-list-${currentId}"></div>
                    <input type="hidden" id="past-owner-nik-${currentId}" name="past_owner_nik[]">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="col-md-12 form-label">Tahun</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="past_owner_year[]">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <label class="col-md-8">&ThinSpace;</label>
                <div class="col-md-12">
                  <button id="delete-past-owner-button-${currentId}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                </div>
              </div>
            </div>
          `);
        $(`#past-owner-nik-input-${currentId}`).on('keyup', function() {
          var nik = $(this).val();
          getResident(`#past-owner-nik-input-${currentId}`, nik, `past-owner-nik-list-${currentId}`, `#past-owner-nik-${currentId}`);
        });

        $(`#delete-past-owner-button-${currentId}`).on('click', function() {
          $(`#past-owner-input-${currentId}`).remove();
        });
      })();
      idCounter++;
    });
  });
</script>
@endsection