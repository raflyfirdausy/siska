{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah Pelaksanaan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Data Pelaksanaan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\ExecutionController@store") }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan isi keterangan pelaksanaan disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul RPJM Desa <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="rpjm_id" id="rpjm_id" class="form-control" title="Pilih salah satu">
                        <option></option>
                        @foreach($rpjm as $r)
                        <option value="{{ $r->id }}">{{ $r->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kategori <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="category" disabled class="form-control" title="Pilih salah satu">
                        <option selected>{{ ucfirst(app('request')->input('kategori')) }}</option>
                      </select>
                      <input type="hidden" name="category" value="{{ app('request')->input('kategori') }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Sumber Anggaran <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="budget_source_id" id="budget_source_id" class="form-control" title="Pilih salah satu">
                        <option></option>
                        @foreach($sources as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
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
                            <input type="radio" name="status" checked value="sesuai">Sesuai
                          </label>
                          <label>
                            <input type="radio" name="status" value="tidak">Tidak Sesuai
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

  function getRPJM() {
    var title = $('#title').val();
    if (title) {
      $.getJSON(`${url}/rpjm/${title}/info?kategori=${kategori}`, function(data) {
        if (data.length > 0) {
            $('#rpjm-list').empty();
            $('#rpjm-list').fadeIn();
            $('#rpjm-list').append(`<ul id="rpjm-result" class="dropdown-menu" style="display:block; position:relative">`);
            $.each(data, function(key, value) {
              $('#rpjm-result').append(`<li 
                onclick="chooseRPJM('${value.id}', '${value.title}', '${value.category}')">
                  Kategori : ${value.category.charAt(0).toUpperCase() + value.category.slice(1)} - Judul : ${value.title}
                </li>`);
            });
        }
      });
    }
  }

  function chooseRPJM(id, title, category) {
    $('#title').attr('value', title);
    $('#rpjm_id').attr('value', id);
    $('#category option:selected').removeAttr('selected');
    $(`#category option[value=${category}`).attr('selected', 'selected');
    $(`span.filter-option.pull-left`).text(category.charAt(0).toUpperCase() + category.slice(1));
    $('#rpjm-list').fadeOut();
  }
  
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
    $('#title').on('keyup', getRPJM);
    $('#source').on('keyup', getSource);
    $('#documentations').on('change', function(e) {
      var wrapper = $('#documentation-wrapper');
      for (var i = 0; i < e.target.files.length; i++) {
        wrapper.append(`<div class="col-md-2"><img src="${window.URL.createObjectURL(e.target.files[i])}" width="100%"></div>`)
      }
    });
  });
</script>
@endsection