@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Migrasi</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Negara Tujuan</th>
      <th>Pekerjaan</th>
      <th>Tanggal Keberangkatan</th>
      <th>PPTKI</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($migration as $r)
    <tr>
      <td>{{ $loop->iteration}}</td>
      <td>{{ $r->resident->nik }}</td>
      <td>{{ $r->resident->name }}</td>
      <td>{{ $r->destination_country }}</td>
      <td>{{ $r->occupation }}</td>
      <td>{{ $r->departure_date }}</td>
      <td>{{ $r->bureau->name }}</td>
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