@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Kematian</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No. </th>
      <th>Nama</th>
      <th>NIK</th>
      <th>TTL</th>
      <th>Umur</th>
      <th>Jenis Kelamin</th>
      <th>Agama</th>
      <th>Pekerjaan</th>
      <th>Alamat</th>

      <th>Tanggal</th>
      <th>Tempat Kematian</th>
      <th>Sebab Kematian</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($kematian as $mati)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$mati->resident['name']}}</td>
      <td>{{$mati->resident['nik']}}</td>
      <td>{{$mati->resident['birth_place']}}, {{$mati->resident['birthday']->format('d-m-Y')}}</td>
      <td>{{$mati->resident['birthday']->age}} th</td>
      <td>{{$mati->resident['gender']}}</td>
      <td>{{$mati->resident['religion']}}</td>
      <td>{{$mati->resident['occupation']->name}}</td>
      <td>{{ $mati->resident->family->alamat_lengkap }}</td>
      <td>{{$mati->date_of_death}}</td>
      <td>{{$mati->place_of_death}}</td>
      <td>{{$mati->cause_of_death}}</td>
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