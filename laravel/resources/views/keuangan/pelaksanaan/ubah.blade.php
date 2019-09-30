{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah Pelaksanaan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> Data Pelaksanaan RPJM {{ $execution->rpjm->title }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\ExecutionController@update", $execution->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan pelaksanaan disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul RPJM Desa <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="rpjm_id" id="rpjm_id" class="form-control" title="Pilih salah satu">
                        <option></option>
                        @foreach($rpjm as $r)
                        <option value="{{ $r->id }}" {{ $execution->rpjm->id == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kategori <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="category" disabled class="form-control" title="Pilih salah satu">
                        <option selected>{{ ucfirst($execution->category) }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Sumber Anggaran <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="budget_source_id" id="budget_source_id" class="form-control" title="Pilih salah satu">
                        <option></option>
                        @foreach($sources as $s)
                        <option value="{{ $s->id }}" {{ $execution->source->id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Status <span class="asterisk">*</span></label>
                    <div class="skin-section">
                      <ul class="list col-md-6">
                        <li class="m-b-20">
                          <label>
                            <input type="radio" name="status" {{ $execution->status == 'sesuai' ? 'checked' : '' }} value="sesuai">Sesuai
                          </label>
                          <label>
                            <input type="radio" name="status" {{ $execution->status == 'tidak' ? 'checked' : '' }} value="tidak">Tidak Sesuai
                          </label>
                        </li>
                      </ul>
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
                <h4>Silahkan tambahkan foto dokumentasi pelaksanaan disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Foto Dokumentasi</label>
                    <input type="file" name="documentations[]" id="documentations" class="form-control" multiple>
                  </div>
                  <div class="row" id="uploaded-documentation-wrapper">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Foto Saat Ini</label>
                        <small class="col-md-12">Tekan gambar untuk menghapusnya</small>
                      </div>
                    </div>
                    @foreach($execution->documentations as $d)
                      <div class="col-md-2 uploaded-image" style="cursor: pointer;">
                        <img src="{{ asset($d->url) }}" class="img-responsive">
                        <input type="hidden" name="uploaded[]" value="{{ $d->id }}">
                      </div>
                    @endforeach
                  </div>
                  <div class="row" style="margin-top: 50px;">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Foto Unggahan Baru</label>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="documentation-wrapper">

                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\ExecutionController@index") }}" class="btn btn-default">Kembali</a>
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
  var kategori = "{{ app('request')->input('kategori') }}"
  
  function getSource() {
    var name = $('#source').val();
    if (name) {
      $.getJSON(`${url}/sumber-anggaran/${name}/info`, function(data) {
        if (data.length > 0) {
            $('#source-list').empty();
            $('#source-list').fadeIn();
            $('#source-list').append(`<ul id="source-result" class="dropdown-menu" style="display:block; position:relative">`);
            $.each(data, function(key, value) {
              $('#source-result').append(`<li 
                onclick="chooseSource('${value.id}', '${value.name}')">
                  ${value.name}
                </li>`);
            });
        }
      });
    }
  }

  function chooseSource(id, name) {
    $('#source').attr('value', name);
    $('#budget_source_id').attr('value', id);
    $('#source-list').fadeOut();
  }

  $(document).ready(function() {
    $('#source').on('keyup', getSource);
    $('#documentations').on('change', function(e) {
      var wrapper = $('#documentation-wrapper');
      for (var i = 0; i < e.target.files.length; i++) {
        wrapper.append(`<div class="col-md-2"><img src="${window.URL.createObjectURL(e.target.files[i])}" width="100%"></div>`)
      }
    });

    $('.uploaded-image').on('click', function(e) {
      $(this).remove();
    });
  });
</script>
@endsection