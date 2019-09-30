{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Pendatang |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data Pendatang {{ $newcomer->resident->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("pendatang/$newcomer->id/ubah") }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan ubah data pendatang disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK</label>
                  <div class="col-md-10">
                    <input class="form-control" disabled value="{{ $newcomer->resident->nik }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama</label>
                  <div class="col-md-10">
                    <input class="form-control" disabled value="{{ $newcomer->resident->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat Asal<span class="asterisk">*</span></label>
                  <div class="col-md-8">
                    <textarea class="form-control" row="6" name="address" required>{{ $newcomer->address }}</textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RT Asal<span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rt" value="{{ $newcomer->rt }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RW Asal<span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rw" value="{{ $newcomer->rw }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun Asal <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="village_name" value="{{ $newcomer->village_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi Asal<span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="province" id="province" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($provinces as $p)
                        <option {{ $newcomer->province == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kabupaten Asal<span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="district" id="district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfDistricts as $p)
                        <option {{ $newcomer->district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kecamatan Asal<span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="sub_district" id="sub_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfSubDistricts as $p)
                        <option {{ $newcomer->sub_district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kelurahan Asal<span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="village" id="village" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfVillages as $p)
                        <option {{ $newcomer->village == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-9 col-sm-offset-3">
                  <div class="pull-right">
                    <a href="{{ url("pendatang") }}" class="btn btn-default">Kembali</a>
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
    $('#date-picker').datepicker();
  });
</script>
@endsection