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
                @elseif ($data->status == 400)
                {{ "Silahkan inputkan Nik" }}
                @else
                <form method="GET" action="{{ url('modul-kependudukan/cetak-keterangan-data-hilang')}}" class="form-vertical">
                    <div class="col-md-12 m-t-10">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="font-weight-bold">Oops, {{ $data->content->RESPON }}, Silahkan isi formulir data dibawah ini untuk membuat pengajuan data diri hilang</h5>
                                        <h4>Formulir pengajuan Data Diri Penduduk</h4>
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-md-12 form-label">NIK</label>
                                                <div class="col-md-12">
                                                    <input required type="text" class="form-control" name="nik" value="{{ $_GET['nik'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12 form-label">Nama Lengkap</label>
                                                <div class="col-md-12">
                                                    <input required name="nama_lengkap" type="text" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Alamat</label>
                                                        <div class="col-md-12">
                                                            <input required name="alamat" type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">RT</label>
                                                        <div class="col-md-12">
                                                            <input required name="rt" type="number" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">RW</label>
                                                        <div class="col-md-12">
                                                            <input required name="rw" type="number" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Kecamatan</label>
                                                        <div class="col-md-12">
                                                            <input required name="kecamatan" type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Kabupaten</label>
                                                        <div class="col-md-12">
                                                            <input required name="kabupaten" type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Tempat Lahir</label>
                                                        <div class="col-md-12">
                                                            <input required name="tempat_lahir" type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Tanggal Lahir</label>
                                                        <input required name="tanggal_lahir" type="date" class="form-control" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 form-label">Jenis Kelamin</label>
                                                        <select required name="jenis_kelamin" required class="form-control" title="Pilih salah satu">
                                                            <option value="LAKI - LAKI">LAKI - LAKI</option>
                                                            <option value="PEREMPUAN">PEREMPUAN</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Golongan Darah</label>
                                                        <select required name="golongan_darah" required class="form-control" title="Pilih salah satu">
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="AB">AB</option>
                                                            <option value="O">O</option>
                                                            <option value="TIDAK TAHU">TIDAK TAHU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Status Perkawinan</label>
                                                        <select required name="status_perkawinan" required class="form-control" title="Pilih salah satu">
                                                            <option value="BELUM KAWIN">BELUM KAWIN</option>
                                                            <option value="KAWIN">KAWIN</option>
                                                            <option value="CERAI HIDUP">CERAI HIDUP</option>
                                                            <option value="CERAI MATI">CERAI MATI</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Agama</label>
                                                        <select required name="agama" required class="form-control" title="Pilih salah satu">
                                                            <option value="ISLAM">ISLAM</option>
                                                            <option value="KRISTEN">KRISTEN</option>
                                                            <option value="KATOLIK">KATOLIK</option>
                                                            <option value="HINDU">HINDU</option>
                                                            <option value="BUDDHA">BUDDHA</option>
                                                            <option value="KOGHUCU">KOGHUCU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Kewarganegaraan</label>
                                                        <div class="col-md-12">
                                                            <input name="kewarganegaraan" required type="text" class="form-control" value="INDONESIA">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Pendidikan Terakhir</label>
                                                        <div class="col-md-12">
                                                            <input name="pendidikan_terakhir" required type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Pekerjaan</label>
                                                        <div class="col-md-12">
                                                            <input name="pekerjaan" required type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-12 form-label">Nomor Surat</label>
                                                        <div class="col-md-12">
                                                            <input name="nomor_surat" required type="text" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Pamong </label>
                                                        <select name="pamong_id" required class="form-control" title="Pilih salah satu">
                                                            <option></option>
                                                            @foreach($officials as $o)
                                                            <option value="{{ $o->id }}">{{ $o->name }} ({{ $o->jabatan }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-primary">Cetak</button>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')

@endsection