@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Penduduk Pendatang</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nomor KK</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Alamat Asal</th>
      <th>Alamat Saat Ini</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($newcomers as $n)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $n->resident->family->no_kk }}</td>
      <td>{{ $n->resident->nik }}</td>
      <td>{{ $n->resident->name }}</td>
      <td>{{ $n->resident->family->alamat_lengkap }}</td>
      <td>{{ $n->alamat_lengkap }}</td>
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