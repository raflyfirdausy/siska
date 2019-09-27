@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Kepindahan Penduduk</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Tanggal Pindah</th>
      <th>Alamat</th>
      <th>Alasan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transfers as $t)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $t->resident->nik }}</td>
      <td>{{ $t->resident->name }}</td>
      <td>{{ $t->date_of_transfer->format('d/m/Y') }}</td>
      <td>{{ $t->alamat_lengkap }}</td>
      <td>{{ $t->alasan }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection

@section('footers')
  <script>
    window.print();
  </script>
@endsection