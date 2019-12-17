{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
Kependudukan |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')

@endsection

{{-- Judul halaman --}}
@section('page-title')
<strong>Statistik</strong> Kependudukan
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="pull-right m-b-5">
            <a href="{{ url('penduduk/statistik/export') }}" class="btn btn-primary"><i class="fa fa-download"></i> Export Excel</a>
        </div>
    </div>
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
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
<script src="{{ asset('plugins/charts-morris/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/charts-morris/morris.min.js') }}"></script>
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
@endsection