@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Penerima Bantuan</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Jenis Bantuan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($beneficiaries as $b)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $b->resident->nik }}</td>
      <td>{{ $b->resident->name }}</td>
      <td>{{ $b->type->name }}</td>
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