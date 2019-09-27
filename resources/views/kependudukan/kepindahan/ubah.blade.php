{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Kepindahan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Kepindahan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("kepindahan/$transfer->id/ubah") }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Silahkan ubah data kepindahan disini</h4>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">NIK</label>
                  <div class="col-md-5">
                    <input class="form-control" disabled value="{{ $resident->nik }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama</label>
                  <div class="col-md-5">
                    <input class="form-control" disabled value="{{ $resident->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat <span class="asterisk">*</span></label>
                  <div class="col-md-8">
                    <textarea class="form-control" row="6" name="destination_address" required>{{ $transfer->destination_address }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="province" id="province" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($provinces as $p)
                        <option {{ $transfer->province == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kabupaten <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="district" id="district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfDistricts as $p)
                        <option {{ $transfer->district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kecamatan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="sub_district" id="sub_district" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfSubDistricts as $p)
                        <option {{ $transfer->sub_district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kelurahan <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="village" id="village" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($listOfVillages as $p)
                        <option {{ $transfer->village == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Tanggal Pindah <span class="asterisk">*</span></label>
                  <div class="col-md-5">
                    <input class="form-control" name="date_of_transfer" value="{{ $transfer->date_of_transfer->format('d/m/Y') }}" id="date-picker" data-date-format="dd/mm/yyyy" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alasan <span class="asterisk">*</span></label>
                  <div class="col-md-5">
                    <select class="form-control" title="Pilih salah satu" name="reason" id="reason" required>
                      <option></option>
                      <option {{ $transfer->reason == 'pekerjaan' ? 'selected' : '' }} value="pekerjaan">Pekerjaan</option>
                      <option {{ $transfer->reason == 'pendidikan' ? 'selected' : '' }} value="pendidikan">Pendidikan</option>
                      <option {{ $transfer->reason == 'keamanan' ? 'selected' : '' }} value="keamanan">Keamanan</option>
                      <option {{ $transfer->reason == 'kesehatan' ? 'selected' : '' }} value="kesehatan">Kesehatan</option>
                      <option {{ $transfer->reason == 'perumahan' ? 'selected' : '' }} value="perumahan">Perumahan</option>
                      <option {{ $transfer->reason == 'keluarga' ? 'selected' : '' }} value="keluarga">Keluarga</option>
                      <option {{ $transfer->reason == 'lainnya' ? 'selected' : '' }} value="lainnya">Lainnya</option>
                    </select>
                  </div>
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