{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Keluarga |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ url("/keluarga/{$family->no_kk}/ubah") }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <h4>Data Keluarga</h4>
                </div>
              </div>
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-12 form-label">Nomor Kartu Keluarga</label>
                  <div class="col-md-12">
                    <input type="number" class="form-control" name="no_kk" value="{{ $family->no_kk }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Alamat</label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" name="address" value="{{ $family->address }}" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RT <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rt" value="{{ $family->rt }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-md-12 form-label">RW <span class="asterisk">*</span></label>
                      <div class="col-md-12">
                        <input type="text" class="form-control" required name="rw" value="{{ $family->rw }}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Nama Dusun <span class="asterisk">*</span></label>
                  <div class="col-md-12">
                    <input type="text" class="form-control" required name="village_name" value="{{ $family->village_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-12 form-label">Provinsi <span class="asterisk">*</span></label>
                  <div class="col-md-6">
                    <select name="province" id="province" class="selectpicker form-control" title="Pilih salah satu">
                      <option></option>
                      @foreach ($provinces as $p)
                        <option {{ $family->province == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $family->district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $family->sub_district == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
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
                        <option {{ $family->village == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="pull-right">
                    <a href="{{ url("keluarga/$family->no_kk") }}" class="btn btn-default">Kembali</a>
                    <a href="{{ url("keluarga/$family->no_kk/tambah-anggota") }}" class="btn btn-info">Tambah Anggota</a>
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
            <div class="row">
              <div class="col-md-6">
                <h4>Anggota Keluarga Saat Ini</h4>
              </div>
            </div>
            @foreach($family->members as $m)
            <div class="col-md-12 member-entry">
              <div class="row member">
                <div class="col-xs-3">
                    <img src="{{$m->resident->photo ?? asset('img/avatars/avatar2.png')}}" alt="{{ $m->resident->name }}" class="pull-left img-responsive">
                </div>
                <div class="col-xs-9">
                  <p class="m-t-0 member-name"><strong>{{ $m->resident->name }}</strong></p>
                  <div class="pull-left">
                    <p><i class="fa fa-user c-gray-light p-r-10"></i> {{ $m->hubungan }}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
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