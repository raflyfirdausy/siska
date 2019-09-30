{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Pengaturan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-title')
    <strong>Ubah</strong> Pengaturan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("/pengaturan/ubah") }}" method="POST" data-parsley-validate enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Aplikasi </label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="application_name" value="{{ $option->application_name }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="province" id="province" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($provinces as $p)
                        <option {{ $option->province == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $option->district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $option->sub_district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $option->village == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="village_name" value="{{ $option->village_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Logo Desa </label>
                  <div class="col-md-12">
                      <input type="file" class="form-control" name="logo">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Gambar Latar Belakang </label>
                  <div class="col-md-12">
                    <input type="file" class="form-control" name="background_image">
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
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Sebutan Kantor <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="office_name" value="{{ $option->office_name }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat Kantor <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <textarea name="office_address"cols="30" rows="10" class="form-control" required>{{ $option->office_address }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Kode Pos <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="postal_code" value="{{ $option->postal_code }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor Telepon <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="phone" value="{{ $option->phone }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Email <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="email" value="{{ $option->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Deskripsi</label>
                  <div class="col-md-12">
                    <textarea name="description"cols="30" rows="10" class="form-control" required>{{ $option->description }}</textarea>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="pull-right">
                    <a href="{{ url("pengaturan") }}" class="btn btn-default">Kembali</a>
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

    $(document).ready(function() {
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