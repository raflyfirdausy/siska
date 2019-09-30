{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Tambah RKP |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Tambah</strong> Data RKP
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\RKPController@store") }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan isi keterangan RKP disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul RPJM Desa <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      {{-- <input type="text" class="form-control" id="title" required autocomplete="false">
                      <div id="rpjm-list"></div>
                      <input type="hidden" name="rpjm_id" id="rpjm_id"> --}}
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
                      <select name="category" id="category" class="form-control" title="Pilih salah satu">
                        <option></option>
                        <option {{ app('request')->input('kategori', false) == 'penyelenggaraan' ? 'selected' : ''  }} value="penyelenggaraan">Penyelenggaraan</option>
                        <option {{ app('request')->input('kategori', false) == 'pelaksanaan' ? 'selected' : ''  }} value="pelaksanaan">Pelaksanaan</option>
                        <option {{ app('request')->input('kategori', false) == 'pembinaan' ? 'selected' : ''  }} value="pembinaan">Pembinaan</option>
                        <option {{ app('request')->input('kategori', false) == 'pemberdayaan' ? 'selected' : ''  }} value="pemberdayaan">Pemberdayaan</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Deskripsi <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Target <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="target" id="target">
                    </div>
                  </div>
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\RKPController@index") }}" class="btn btn-default">Kembali</a>
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
{{-- <script>
  var url = "{{ URL::to('/') }}";
  var kategori = "{{ app('request')->input('kategori') }}"

  function getRPJM() {
    var title = $('#title').val();
    if (title) {
      $.getJSON(`${url}/rpjm/${title}/info`, function(data) {
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

  $(document).ready(function() {
      $('#title').on('keyup', getRPJM);
    });
</script> --}}
@endsection