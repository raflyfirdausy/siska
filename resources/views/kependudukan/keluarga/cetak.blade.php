@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Keluarga</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nomor KK</th>
      <th>Kepala Keluarga</th>
      <th>Alamat</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($families as $f)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $f->no_kk }}</td>
      <td>{{ $f->familyHead()->name }}</td>
      <td>{{ $f->alamat_lengkap }}</td>
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