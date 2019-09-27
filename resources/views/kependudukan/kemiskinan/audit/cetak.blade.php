@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Audit Kemiskinan</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Tanggal</th>
      <th>Hasil</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($audits as $a)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $a->resident->nik }}</td>
      <td>{{ $a->resident->name }}</td>
      <td>{{ $a->created_at->format('d/m/Y') }}</td>
      <td>{{ $a->result == 'miskin' ? 'Dinyatakan Miskin' : 'Tidak Miskin' }}</td>
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