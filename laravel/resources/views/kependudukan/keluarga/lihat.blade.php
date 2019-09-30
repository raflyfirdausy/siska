{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Lihat Keluarga |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Keluarga</strong> {{ $family->familyHead()->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
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
                  <input type="text" class="form-control" value="{{ $family->no_kk }}" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 form-label">Alamat</label>
                <div class="col-md-12">
                  <textarea class="form-control" disabled>{{ $family->alamat_lengkap }}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mt-20">
            <div class="pull-right">
              <a href="{{ url("keluarga") }}" class="btn btn-default">Kembali</a>
              <a href="{{ url("keluarga/$family->no_kk/ubah") }}" class="btn btn-info">Ubah</a>
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
              <h4>Anggota Keluarga</h4>
            </div>
          </div>
          @foreach($family->members()->canBeDisplayed()->get() as $m)
          <div class="col-md-12">
            <div class="row member">
              <div class="col-xs-3">
                  <img src="{{$m->resident->photo ? asset($m->resident->photo) : asset('img/avatars/avatar2.png')}}" alt="{{ $m->resident->name }}" class="pull-left img-responsive">
              </div>
              <div class="col-xs-9">
                <div class="pull-right">
                    <a href="{{ url("penduduk/".$m->resident->nik) }}" class="btn btn-info"> Lihat</a>
                </div>
                <p class="m-t-0 member-name"><strong>{{ $m->resident->name }}</strong></p>
                <div class="pull-left">
                  <p><i class="fa fa-user c-gray-light p-r-10"></i> {{ $m->hubungan }}</p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          
          <div class="col-md-12">
            <div class="pull-right">
              <a href="{{ url("keluarga/$family->no_kk/tambah-anggota") }}" class="btn btn-success">Tambah</a>
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
    $(document).ready(function() {
      $('#date-picker').datepicker();
    });
  </script>
@endsection