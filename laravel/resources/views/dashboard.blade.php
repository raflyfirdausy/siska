{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
Dashboard |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
<link href="{{asset('plugins/metrojs/metrojs.css')}}" rel="stylesheet">
@endsection

{{-- Judul halaman --}}
@section('page-title')
<h2>Dashboard</h2>
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div id="main-content" class="dashboard">
  <div class="row m-t-20">
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <div class="panel-body bg-blue p-15">
          <div class="row m-b-6">
            <div class="col-xs-3">
              <i class="glyph-icon flaticon-visitors"></i>
            </div>
            <div class="col-xs-9">
            <small class="stat-title">JUMLAH KEPALA KELUARGA</small>
              <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahKepalaKeluarga[0]["value"] + $jumlahKepalaKeluarga[1]["value"] }}" data-animation-duration="1500">0</span></h1>              
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <small class="stat-title">Pria</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahKepalaKeluarga[0]["value"] }}" data-animation-duration="1500">0</span></h3>            
            </div>
            <div class="col-xs-6">
              <small class="stat-title">Wanita</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahKepalaKeluarga[1]["value"] }}" data-animation-duration="1500">0</span></h3>              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <div class="panel-body bg-red p-15">
          <div class="row m-b-6">
            <div class="col-xs-3">
              <i class="glyph-icon flaticon-user92"></i>
            </div>
            <div class="col-xs-9">
              <small class="stat-title">JUMLAH PENDUDUK</small>
              <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahJiwa[0]["value"] + $jumlahJiwa[1]["value"] }}" data-animation-duration="1500">0</span></h1>             
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <small class="stat-title">Pria</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahJiwa[0]["value"]  }}" data-animation-duration="1500">0</span></h3>              
            </div>
            <div class="col-xs-6">
              <small class="stat-title">Wanita</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $jumlahJiwa[1]["value"]  }}" data-animation-duration="1500">0</span></h3>              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <div class="panel-body bg-green p-15">
          <div class="row m-b-6">
            <div class="col-xs-3">
              <i class="glyph-icon flaticon-pages"></i>
            </div>
            <div class="col-xs-9">
              <small class="stat-title">JUMLAH SURAT</small>
              <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $totalMails }}" data-animation-duration="1400">0</span></h1>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <small class="stat-title">Surat Masuk</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $inboxCount }}" data-animation-duration="1400">0</span></h3>
            </div>
            <div class="col-xs-6">
              <small class="stat-title">Surat Keluar</small>
              <h3 class="m-0 w-500"><span class="animate-number" data-value="{{ $outboxCount }}" data-animation-duration="1400">0</span></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">      
      <h4><b>Statistik Data Kependudukan</b></h4>
    </div>
    <div class="col-md-6">
        <a href="{{ url('/dashboard/download-statistik') }}" class="btn btn-md btn-info pull-right"><i class="fa fa-download"></i> Download Statistik Lengkap</a>
    </div>
  </div>

  <div class="row">
     <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <h3 class="m-b-0 m-t-0"><strong>Jumlah </strong> Jiwa</h3>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div id="chart-jumlah-jiwa"></div>
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
                    <h3 class="m-b-0 m-t-0"><strong>Jumlah </strong> Kepala Keluarga</h3>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div id="chart-kepala-keluarga"></div>
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
                    <h3 class="m-b-0 m-t-0"><strong>Jumlah </strong> Kepemilikan Kartu Keluarga</h3>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div id="chart-kepemilikan-kartu-keluarga"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  {{-- <div class="row m-t-20">
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <a href="{{ action('Residency\BirthController@create') }}">
          <div class="panel-body bg-white p-15">
            <div class="row m-b-6">
              <div class="col-xs-3">
                <i class="glyph-icon flaticon-heart13"></i>
              </div>
              <div class="col-xs-9">
                <small class="stat-title">KELAHIRAN</small>
                <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $birthsCount }}" data-animation-duration="1400">0</span></h1>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <a href="{{ action('Residency\TransferController@create') }}">
          <div class="panel-body bg-purple p-15">
            <div class="row m-b-6">
              <div class="col-xs-3">
                <i class="glyph-icon flaticon-world30"></i>
              </div>
              <div class="col-xs-9">
                <small class="stat-title">KEPINDAHAN</small>
                <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $transfersCount }}" data-animation-duration="1400">0</span></h1>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-4 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <a href="{{ action('Residency\NewcomerController@create') }}">
          <div class="panel-body bg-red p-15">
            <div class="row m-b-6">
              <div class="col-xs-3">
                <i class="glyph-icon flaticon-star105"></i>
              </div>
              <div class="col-xs-9">
                <small class="stat-title">PENDATANG</small>
                <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $newcomersCount }}" data-animation-duration="1400">0</span></h1>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="row m-t-20">
    <div class="col-md-6 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <a href="{{ action('Residency\LaborMigrationController@create') }}">
          <div class="panel-body bg-orange p-15">
            <div class="row m-b-6">
              <div class="col-xs-3">
                <i class="glyph-icon flaticon-incomes"></i>
              </div>
              <div class="col-xs-9">
                <small class="stat-title">MIGRASI TKI</small>
                <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $migrationsCount }}" data-animation-duration="1400">0</span></h1>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="panel no-bd bd-3 panel-stat">
        <a href="{{ action('Residency\DeathController@create') }}">
          <div class="panel-body bg-dark p-15">
            <div class="row m-b-6">
              <div class="col-xs-3">
                <i class="glyph-icon flaticon-church2"></i>
              </div>
              <div class="col-xs-9">
                <small class="stat-title">KEMATIAN</small>
                <h1 class="m-0 w-500"><span class="animate-number" data-value="{{ $deathsCount }}" data-animation-duration="1400">0</span></h1>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div> --}}
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')

<script>
  $(document).ready(function() {
        new Morris.Donut({
            element: 'chart-jumlah-jiwa',
            data: @json($jumlahJiwa),
            colors: ["#2c3e50", "#e74c3c"],
            formatter: function(x) {
                return x;
            }
        });

        new Morris.Donut({
            element: 'chart-kepala-keluarga',
            data: @json($jumlahKepalaKeluarga),
            colors: ['#3498db', '#2c3e50'],
            formatter: function(x) {
                return x;
            }
        });

        new Morris.Donut({
            element: 'chart-kepemilikan-kartu-keluarga',
            data: @json($jumlahKepemilikanKartuKeluarga),
            colors: ['#e67e22', '#2c3e50'],
            formatter: function(x) {
                return x;
            }
        });

    });
</script>
<script src="{{asset('plugins/metrojs/metrojs.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('plugins/charts-morris/raphael.min.js')}}"></script>
<script src="{{asset('plugins/charts-morris/morris.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
@endsection