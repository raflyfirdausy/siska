{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Kepindahan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Kepindahan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url('kepindahan/tambah') }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan isi data kepindahan baru disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Kepindahan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select class="form-control" title="Pilih salah satu" name="transfer_type" id="transfer_type" required>
                      <option></option>
                      <option value="1">Satu Keluarga</option>
                      <option value="2">Beberapa Anggota Keluarga</option>
                      <option value="3">Individu</option>
                    </select>
                  </div>
                </div>
                <div class="form-group" id="transfer-field-1">
                  
                </div>
                <div class="form-group" id="transfer-field-2">
                  
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <textarea class="form-control" row="10" name="destination_address" required></textarea>
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
                <div class="form-group">
                  <label class="col-md-12 form-label">Tanggal Pindah <span class="asterisk">*</span></label>
                  <div class="col-md-5">
                    <input class="form-control" name="date_of_transfer" id="date-picker" data-date-format="dd/mm/yyyy" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alasan <span class="asterisk">*</span></label>
                  <div class="col-md-5">
                    <select class="form-control" title="Pilih salah satu" name="reason" id="reason" required>
                      <option></option>
                      <option value="pekerjaan">Pekerjaan</option>
                      <option value="pendidikan">Pendidikan</option>
                      <option value="keamanan">Keamanan</option>
                      <option value="kesehatan">Kesehatan</option>
                      <option value="perumahan">Perumahan</option>
                      <option value="keluarga">Keluarga</option>
                      <option value="lainnya">Lainnya</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label>
                    <input type="checkbox" name="confirm" value="1" required>Apakah data yang Anda masukkan sudah benar? Mohon dicek kembali
                  </label>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("kepindahan") }}" class="btn btn-default">Kembali</a>
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

  var transferFields = [
    $('#transfer-field-1'),
    $('#transfer-field-2'),
  ];

  function getMembers() {
    var kk = $('#preview-text').val();
    if (kk) {
      $.getJSON(url + '/keluarga/' + kk + '/kepala', function(data) {
        if (data.length > 0) {
          $('#recommendation-list').empty();
          $('#recommendation-list').fadeIn();
          $('#recommendation-list').append('<ul id="recommendation" class="dropdown-menu" style="display:block; position:relative">');
          $.each(data, function(key, value) {
            $('#recommendation').append(`<li 
              onclick="chooseFamilyForMembers('${value.no_kk}')">
                Nomor KK : ${value.no_kk} - Kepala Keluarga : ${value.head.name}
              </li>`);
          });
        }
      });
    }
  }

  function chooseFamilyForMembers(kk) {
    $('#no_kk').attr('value', kk);
    $('#preview-text').attr('value', kk);
    $('#recommendation-list').fadeOut();
    $.getJSON(url + '/keluarga/' + kk + '/anggota', function(data) {
      if (data.length < 1) {
        $('#members-checkbox').empty();
      }

      var items = [];
      $.each(data, function(key, val) {
        items.push('<li><label><input type="checkbox" name="resident_id[]" value="' + val.resident_id + '">' + val.name +'</label></li>');
      });
      $('#members-checkbox').html(items.join(''));
    })
  }

  function getFamily() {
    var kk = $('#preview-text').val();
    if (kk) {
      $.getJSON(url + '/keluarga/' + kk + '/kepala', function(data) {
        if (data.length > 0) {
          $('#recommendation-list').empty();
          $('#recommendation-list').fadeIn();
          $('#recommendation-list').append('<ul id="recommendation" class="dropdown-menu" style="display:block; position:relative">');
          $.each(data, function(key, value) {
            $('#recommendation').append(`<li 
              onclick="chooseFamily('${value.no_kk}', '${value.head_name}')">
                Nomor KK : ${value.no_kk} - Kepala Keluarga : ${value.head.name}
              </li>`);
          });
        }
      });
    }
  }

  function chooseFamily(kk, kepala) {
    $('#no_kk').attr('value', kk);
    $('#preview-text').attr('value', `${kk} - Kepala Keluarga : ${kepala}`);
    $('#recommendation-list').fadeOut();
  }

  function getResident() {
    var nik = $('#preview-text').val();
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

  function chooseResident(nik, name) {
    $('#nik').attr('value', nik);
    $('#preview-text').attr('value', `${nik} - Nama : ${name}`);
    $('#recommendation-list').fadeOut();
  }


  var regionContainers = [
    $('#province'), $('#district'), $('#sub_district'), $('#village'),
  ];

  function emptyList(index) {
    for (var i = index; i < regionContainers.length; i++) {
      regionContainers[i].empty();
      regionContainers[i].append('<option>');
    }
  }
  $(document).ready(function(){
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

    function clearFields() {
      for (var i = 0; i < transferFields.length; i++) {
        transferFields[i].empty();
      }
    }

    function handleTransferOneFamily() {
      transferFields[0].html(`
      <label class="col-md-12 form-label">
        Nomor KK <span class="asterisk">*</span>
      </label>
      <div class="col-md-10">
        <input onkeyup="getFamily()" type="text" class="form-control" id="preview-text">
        <div id="recommendation-list"></div>
        <input type="hidden" name="no_kk" id="no_kk">
      </div>`
      );
    }
    function handleTransferSomeMembers() {
      transferFields[0].html(`
        <label class="col-md-12 form-label">Nomor KK <span class="asterisk">*</span></label>
          <div class="col-md-10">
              <input onkeyup="getMembers()" type="text" class="form-control" id="preview-text" autocomplete="false">
              <div id="recommendation-list"></div>
              <input type="hidden" name="no_kk" id="no_kk">
          </div>
      `);
      transferFields[1].html(`
        <label class="col-md-12 form-label">Anggota Keluarga <span class="asterisk">*</span></label>
          <div class="col-md-12">
              <ul id="members-checkbox">
              </ul>    
          </div>
      `);
    }
    function handleTransferIndividual() {
      transferFields[0].html(`
        <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
          <div class="col-md-10">
              <input onkeyup="getResident()" type="text" class="form-control" id="preview-text" autocomplete="false">
              <div id="recommendation-list"></div>
              <input type="hidden" name="nik" id="nik">
          </div>
      `);
    }
    
    $('#transfer_type').on('change', function(){
      clearFields();
      switch ($(this).val()) {
        case 1:
        case '1':
          handleTransferOneFamily();
          break;
        case 2:
        case '2':
          handleTransferSomeMembers();
          break;
        case 3:
        case '3':
          handleTransferIndividual();
          break;
      }
        
    });
    $('#date-picker').datepicker();
  });
</script>
@endsection
