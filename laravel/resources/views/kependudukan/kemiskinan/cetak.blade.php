@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Kemiskinan</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($poverties as $p)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $p->resident->nik }}</td>
      <td>{{ $p->resident->name }}</td>
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