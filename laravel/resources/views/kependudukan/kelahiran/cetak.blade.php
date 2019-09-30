@extends('layouts.master')

@section('headers')
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('body')
<div class="text-center">
  <h4>Daftar Kelahiran</h4>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Bayi</th>
      <th>Nama Bapak</th>
      <th>Nama Ibu</th>
      <th>Berat</th>
      <th>Tinggi</th>
      <th>Tanggal Lahir</th>
      <th>Pada Jam</th>
      <th>Tempat Kelahiran</th>
      <th>Anak Ke</th>
      <th>Tempat Persalinan</th>
      <th>Pembantu Persalinan</th>
      <th>Pelapor</th>
      <th>Saksi Pertama</th>
      <th>Saksi Kedua</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($births as $b)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $b->resident->name }}</td>
      <td>{{ $b->father->name}}</td>
      <td>{{ $b->mother->name}}</td>
      <td>{{ $b->weight}}kg</td>
      <td>{{ $b->height}}cm</td>
      <td>{{ $b->date_of_birth->format('d/m/Y')}}</td>
      <td>{{ $b->time_of_birth}}</td>
      <td>{{ $b->place_of_birth}}</td>
      <td>{{ $b->child_number}}</td>
      <td>{{ $b->tempatBersalin}}</td>
      <td>{{ $b->pembantuPersalinan}}</td>
      <td>{{ $b->reporter}}</td>
      <td>{{ $b->first_witness}}</td>
      <td>{{ $b->second_witness}}</td>
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