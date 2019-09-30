{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Ubah Penerima Bantuan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Ubah</strong> Penerima Bantuan {{ $beneficiary->resident->name }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<form action="{{ action('Residency\BeneficiaryController@update', $beneficiary->id) }}" method="POST" data-parsley-validate>
  @csrf
  <div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
      <div class="col-md-12">
        <h4>Silahkan ubah data penerima bantuan disini</h4>
        <div class="form-horizontal">
        <div class="form-group">
          <label class="col-md-12 form-label">NIK <span class="asterisk">*</span></label>
          <div class="col-md-10">
            <input class="form-control" value="{{ $beneficiary->resident->nik }}" type="text" disabled>
            <div id="recommendation-list"></div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 form-label">Nama</label>
          <div class="col-md-10">
            <input class="form-control" value="{{ $beneficiary->resident->name }}" type="text" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-12 form-label">Jenis Bantuan</label>
          <div class="col-md-10">
            <select name="beneficiary_type_id">
              <option></option>
              @foreach ($types as $t)
                <option {{ $beneficiary->type->id == $t->id ? 'selected' : '' }} value="{{ $t->id }}">{{ $t->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3">
          <div class="pull-right">
          <a href="{{ action('Residency\BeneficiaryController@index') }}" class="btn btn-default">Kembali</a>
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

@endsection
