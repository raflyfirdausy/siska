@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Penduduk</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Jenis Kelamin</th>
      <th>TTL</th>
      <th>Pendidikan</th>
      <th>Pekerjaan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($residents as $r)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $r->nik }}</td>
      <td>{{ $r->name }}</td>
      <td>{{ $r->jenkel }}</td>
      <td>{{ $r->birth_place }}, {{ $r->birthday->format('d/m/Y') }}</td>
      <td>{{ $r->education->name }}</td>
      <td>{{ $r->occupation->name }}</td>
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