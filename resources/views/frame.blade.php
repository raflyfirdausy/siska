{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Dashboard |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Dashboard</strong>
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')

@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')

@endsection