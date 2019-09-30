{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
    Statistik Penduduk |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
    
@endsection

{{-- Judul halaman --}}
@section('page-title')
    <strong>Statistik</strong> Penduduk
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <h3 class="m-b-30"><strong>Jenis </strong> Kelamin</h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="chart-gender"></div>
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
            <h3 class="m-b-30"><strong>Status </strong> Pernikahan</h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="chart-marriage"></div>
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
            <h3 class="m-b-30"><strong>Agama </strong></h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="chart-religion"></div>
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
            <h3 class="m-b-30"><strong>Golongan </strong>Darah</h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="chart-blood-type"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
            <h3 class="m-b-30"><strong>Pendidikan </strong></h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-12">
                    <div id="chart-education"></div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
            <h3 class="m-b-30"><strong>Pekerjaan </strong></h3>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-12">
                    <div id="chart-occupation"></div>
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
  <script src="{{ asset('plugins/charts-morris/raphael.min.js') }}"></script>
  <script src="{{ asset('plugins/charts-morris/morris.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      new Morris.Donut({
        element: 'chart-gender',
        data: @json($genders),
        colors: ['#0090D9', '#C75757',],
        formatter: function (x) {
            return x;
        }
      });

      new Morris.Donut({
        element: 'chart-religion',
        data: @json($religions),
        colors: ['#18A689', '#C75757', '#0090D9', '#2B2E33', '#0090D9',],
        formatter: function (x) {
            return x;
        }
      });

      new Morris.Donut({
        element: 'chart-blood-type',
        data: @json($bloodTypes),
        colors: ['#18A689', '#C75757', '#0090D9', '#2B2E33', '#0090D9',],
        formatter: function (x) {
            return x;
        }
      });

      new Morris.Donut({
        element: 'chart-marriage',
        data: @json($marriages),
        colors: ['#18A689', '#C75757', '#0090D9', '#2B2E33', '#0090D9',],
        formatter: function (x) {
            return x;
        }
      });

      new Morris.Bar({
        element: 'chart-education',
        data: @json($educations),
        xkey: 'label',
        ykeys: ['value'],
        labels: ['Jumlah'],
        barColors: ['#18A689', '#C75757', '#0090D9', '#2B2E33', '#0090D9',],
        barRatio: 0.4,
        xLabelAngle: 25,
        hideHover: 'auto',
        resize: true,
      });

      new Morris.Bar({
        element: 'chart-occupation',
        data: @json($occupations),
        xkey: 'label',
        ykeys: ['value'],
        labels: ['Jumlah'],
        barColors: ['#18A689', '#C75757', '#0090D9', '#2B2E33', '#0090D9',],
        barRatio: 0.4,
        xLabelAngle: 25,
        hideHover: 'auto',
        resize: true,
      });
    });
  </script>
@endsection