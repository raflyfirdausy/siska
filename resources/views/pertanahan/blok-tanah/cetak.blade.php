@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Blok Tanah</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>Nomor Blok</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($landBlocks as $b)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $b->number }}</td>
      <td>{{ $b->note }}
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