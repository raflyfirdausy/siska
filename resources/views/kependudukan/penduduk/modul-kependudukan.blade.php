{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
Daftar Pemilih Tetap |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')

@endsection

{{-- Judul halaman --}}
@section('page-title')
<strong>Testing </strong> Modul Kependudukan<br>
Nik Contoh : <strong>3304061303090001 / 3304062007780002 / 3304064308830001</strong>
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
                    <!-- @csrf -->
                        <div class="col-md-6" style="padding-left: 0;">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                                    <input name="nik" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if($data->status == 200)
                <table id="posts-table" class="table table-tools table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>TTL</th>
                            <th>Umur</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                            <th colspan="2" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $data->content[0]->NIK }}</td>
                            <td>{{ $data->content[0]->NAMA_LGKP }}</td>
                            <td>{{ $data->content[0]->JENIS_KLMIN }}</td>
                            <td>{{ $data->content[0]->TMPT_LHR }}, {{ $data->content[0]->TGL_LHR }}</td>
                            <td>{{ $data->content[0]->AGE }} Tahun</td>
                            <td>{{ $data->content[0]->PDDK_AKH }}</td>
                            <td>{{ $data->content[0]->JENIS_PKRJN }}</td>
                            <td class="text-center">
                                <a href="modul-kependudukan/detail/{{ $data->content[0]->NIK }}" class="btn btn-info" style="margin-bottom:0px;">Lihat</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @else
                {{ $data->content->RESPON }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')

@endsection