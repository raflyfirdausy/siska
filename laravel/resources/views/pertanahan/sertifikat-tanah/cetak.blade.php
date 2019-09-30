@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Sertifikat Tanah</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>Nomor Sertifikat</th>
      <th>Pemilik Saat Ini</th>
      <th>Pemilik Sebelumnya</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($lands as $l)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $l->number }}</td>
      <td>{{ $l->resident->name }}</td>
      <td>{{ $l->pemilik_sebelumnya }}</td>
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