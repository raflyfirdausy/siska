{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Ubah APBD Desa |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Ubah</strong> APBD Desa {{ $apbd->rpjm->title }}
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
  <form action="{{ action("Finance\APBDController@update", $apbd->id) }}" method="POST" data-parsley-validate>
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <h4>Silahkan ubah keterangan APBD Desa disini</h4>
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-md-12 form-label">Judul RPJM Desa <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                        <select name="rpjm_id" id="rpjm_id" class="form-control" title="Pilih salah satu">
                            <option></option>
                            @foreach($rpjm as $r)
                            <option value="{{ $r->id }}" {{ $apbd->rpjm->id == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                            @endforeach
                          </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Kategori <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <select name="category" disabled class="form-control" title="Pilih salah satu">
                        <option selected>{{ ucfirst($apbd->category) }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12 form-label">Anggaran <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" value="{{ $apbd->budget }}" name="budget" required autocomplete="false">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Mulai <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" value="{{ $apbd->start_date->format('Y-m-d') }}" name="start_date" required autocomplete="false">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-md-12 form-label">Tanggal Selesai <span class="asterisk">*</span></label>
                        <div class="col-md-12">
                          <input type="date" class="form-control" value="{{ $apbd->end_date->format('Y-m-d') }}" name="end_date" required autocomplete="false">
                        </div>
                      </div>
                    </div>
                  </div>
                  @if (in_array($apbd->category, ['pemberdayaan', 'pembinaan', 'pelaksanaan']))
                  <div class="form-group">
                    <label class="col-md-12 form-label">Jumlah Peserta <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" value="{{ $apbd->participants }}" name="participants" required autocomplete="false">
                    </div>
                  </div>
                  @endif
                  @if ($apbd->category == 'pelaksanaan')
                  <div class="form-group">
                    <label class="col-md-12 form-label">Luas Bangunan <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                      <input type="number" class="form-control" name="building_area" value="{{ $apbd->building_area }}" required autocomplete="false">
                    </div>
                  </div>
                  @endif
                  @if ($apbd->category == 'pemberdayaan')
                  <div class="form-group">
                    <label class="col-md-12 form-label">Usaha <span class="asterisk">*</span></label>
                    <div class="col-md-12">
                        <select name="village_business_id" id="village_business_id" class="form-control" title="Pilih salah satu">
                          <option></option>
                          @foreach($businesses as $b)
                          <option value="{{ $b->id }}" {{ $apbd->business->id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  @endif
                  <div class="col-sm-9 col-sm-offset-3">
                    <div class="pull-right">
                      <a href="{{ action("Finance\APBDController@index") }}" class="btn btn-default">Kembali</a>
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
  
  function getBusiness() {
    var name = $('#business').val();
    if (name) {
      $.getJSON(`${url}/usaha-desa/${name}/info`, function(data) {
        if (data.length > 0) {
            $('#business-list').empty();
            $('#business-list').fadeIn();
            $('#business-list').append(`<ul id="business-result" class="dropdown-menu" style="display:block; position:relative">`);
            $.each(data, function(key, value) {
              $('#business-result').append(`<li 
                onclick="chooseBusiness('${value.id}', '${value.name}')">
                  ${value.name}
                </li>`);
            });
        }
      });
    }
  }

  function chooseBusiness(id, name) {
    $('#business').attr('value', name);
    $('#village_business_id').attr('value', id);
    $('#business-list').fadeOut();
  }

  $(document).ready(function() {
      $('#business').on('keyup', getBusiness);
    });
</script>
@endsection