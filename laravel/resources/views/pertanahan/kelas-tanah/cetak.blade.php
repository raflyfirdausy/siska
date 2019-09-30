@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Kelas Tanah</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>Kode</th>
      <th>Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($landClasses as $c)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $c->code }}</td>
      <td>{{ $c->price }}</td>
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