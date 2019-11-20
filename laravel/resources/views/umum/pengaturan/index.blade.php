{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Pengaturan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
<strong>Pengaturan</strong>
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-md-12 form-label">Nama Aplikasi</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" disabled value="{{ $option->application_name }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Provinsi </label>
                <div class="col-md-6">
                  <select name="province" id="province" disabled class="selectpicker form-control">
                      <option>{{ $option->provinsi->name }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Kabupaten </label>
                <div class="col-md-6">
                  <select name="province" id="province" disabled class="selectpicker form-control">
                      <option>{{ $option->kabupaten->name }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Kecamatan </label>
                <div class="col-md-6">
                  <select name="sub_district" id="sub_district" disabled class="selectpicker form-control">
                    <option>{{ $option->kecamatan->name }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Kelurahan / Desa </label>
                <div class="col-md-6">
                  <select name="village" id="village" disabled class="selectpicker form-control">
                      <option>{{ $option->desa->name }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Nama Dusun </label>
                <div class="col-md-12">
                  <input type="text" disabled class="form-control" required name="village_name" value="{{ $option->village_name }}">
                </div>
              </div>
              {{-- <div class="form-group">
                <label class="col-md-12 form-label">Logo Desa </label>
                <div class="col-md-12">
                  @if ($option->logo)
                  <img src="{{ asset($option->logo) }}" alt="" class="img-responsive">
                  @else
                  <small>Belum terdapat logo desa</small>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Gambar Latar Belakang </label>
                <div class="col-md-12">
                  @if ($option->background_image)
                  <img src="{{ asset($option->background_image) }}" alt="" class="img-responsive">
                  @else
                  <small>Belum terdapat gambar latar belakang</small>
                  @endif
                </div>
              </div> --}}
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
                <label class="col-md-12 form-label">Sebutan Kantor</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="office_name" value="{{ $option->office_name }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Alamat Kantor</label>
                <div class="col-md-12">
                  <textarea name="office_address"cols="30" rows="10" class="form-control" disabled>{{ $option->office_address }}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Kode Pos</label>
                <div class="col-md-12">
                  <input type="text" class="form-control" disabled name="postal_code" value="{{ $option->postal_code }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Nomor Telepon </label>
                <div class="col-md-12">
                  <input type="text" class="form-control" disabled name="phone" value="{{ $option->phone }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Email </label>
                <div class="col-md-12">
                  <input type="text" class="form-control" disabled name="phone" value="{{ $option->email }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Deskripsi</label>
                <div class="col-md-12">
                  <textarea name="description"cols="30" rows="10" class="form-control" disabled>{{ $option->description }}</textarea>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="pull-right">
                  <a href="{{ url("pengaturan/ubah") }}" class="btn btn-warning">Ubah</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <script>
  </script>
@endsection