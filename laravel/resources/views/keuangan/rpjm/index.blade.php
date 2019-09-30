{{-- Extends view yang ada pada file layouts/admin.blade.php --}}
@extends('layouts.admin')

{{-- Judul di tab, selalu tambahin karakter | di akhir --}}
@section('tab-title')
  Rencana Pembangunan Jangka Menengah |
@endsection

{{-- Untuk menambahkan custom css file atau meta baru di header --}}
@section('page-headers')
  
@endsection

{{-- Judul halaman --}}
@section('page-title')
  <strong>Rencana Pembangunan Jangka Menengah</strong>
@endsection

{{-- Isi dari halaman, konten utama dari suatu halaman --}}
@section('page-content')
<div class="row">
  <div class="col-md-12">
    <div class="tabcordion">
      <ul id="tab" class="nav nav-tabs">
        <li class="{{ app('request')->input('penyelenggaraan', false) ? 'active' : (count(app('request')->all()) == 0 ? 'active' : '') }}">
          <a href="#penyelenggaraan" data-toggle="tab">Penyelenggaraan</a>
        </li>
        <li class="{{ app('request')->input('pelaksanaan', false) ? 'active' : '' }}">
          <a href="#pelaksanaan" data-toggle="tab">Pelaksanaan</a>
        </li>
        <li class="{{ app('request')->input('pembinaan', false) ? 'active' : '' }}">
          <a href="#pembinaan" data-toggle="tab">Pembinaan</a>
        </li>
        <li class="{{ app('request')->input('pemberdayaan', false) ? 'active' : '' }}">
          <a href="#pemberdayaan" data-toggle="tab">Pemberdayaan</a>
        </li>
      </ul>
      <div id="tab-contents" class="tab-content">
        <div class="tab-pane fade {{ app('request')->input('penyelenggaraan', false) ? 'active in' : (count(app('request')->all()) == 0 ? 'active in' : '') }}" id="penyelenggaraan">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
                  <div class="col-md-6" style="padding-left: 0;">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                        <input type="hidden" name="penyelenggaraan" value="1">
                        <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group">
                        <select name="tahun" id="tahun" class="form-control">
                          <option>Tahun</option>
                          @foreach($years as $y)
                          <option value="{{ $y }}">{{ $y }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="col-md-6">
                  <div class="pull-right">
                    {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
                    <a href="{{ url("rpjm/tambah?kategori=penyelenggaraan") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
                  </div>
                </div>
              </div>
              <table id="posts-table" class="table table-tools table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($penyelenggaraan as $p)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->year }}</td>
                    <td class="text-center">
                      <div class="form-group">
                        <a href="{{ url("rpjm/$p->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0"> Ubah</a>
                        <button type="submit" class="btn btn-danger delete-button" data-id="{{ $p->id }}" data-nama="{{ $p->title }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
              <div class="pull-right">
                {{ $penyelenggaraan->appends($_GET)->links() }}
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade {{ app('request')->input('pelaksanaan', false) ? 'active in' : '' }}" id="pelaksanaan">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
                  <div class="col-md-6" style="padding-left: 0;">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                        <input type="hidden" name="pelaksanaan" value="1">
                        <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group">
                        <select name="tahun" id="tahun" class="form-control">
                          <option>Tahun</option>
                          @foreach($years as $y)
                          <option value="{{ $y }}">{{ $y }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="col-md-6">
                  <div class="pull-right">
                    {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
                    <a href="{{ url("rpjm/tambah?kategori=pelaksanaan") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
                  </div>
                </div>
              </div>
              <table id="posts-table" class="table table-tools table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pelaksanaan as $p)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->year }}</td>
                    <td class="text-center">
                      <div class="form-group">
                        <a href="{{ url("rpjm/$p->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0"> Ubah</a>
                        <button type="submit" class="btn btn-danger delete-button" data-id="{{ $p->id }}" data-nama="{{ $p->title }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
              <div class="pull-right">
                {{ $pelaksanaan->appends($_GET)->links() }}
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade {{ app('request')->input('pembinaan', false) ? 'active in' : '' }}" id="pembinaan">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
                  <div class="col-md-6" style="padding-left: 0;">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                        <input type="hidden" name="pembinaan" value="1">
                        <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group">
                        <select name="tahun" id="tahun" class="form-control">
                          <option>Tahun</option>
                          @foreach($years as $y)
                          <option value="{{ $y }}">{{ $y }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="col-md-6">
                  <div class="pull-right">
                    {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
                    <a href="{{ url("rpjm/tambah?kategori=pembinaan") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
                  </div>
                </div>
              </div>
              <table id="posts-table" class="table table-tools table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pembinaan as $p)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->year }}</td>
                    <td class="text-center">
                      <div class="form-group">
                        <a href="{{ url("rpjm/$p->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0"> Ubah</a>
                        <button type="submit" class="btn btn-danger delete-button" data-id="{{ $p->id }}" data-nama="{{ $p->title }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
              <div class="pull-right">
                {{ $pembinaan->appends($_GET)->links() }}
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade {{ app('request')->input('pemberdayaan', false) ? 'active in' : '' }}" id="pemberdayaan">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <form method="GET" action="{{ url()->current() }}" class="form-horizontal">
                  <div class="col-md-6" style="padding-left: 0;">
                    <div class="col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon" id="addon"><i class="fa fa-search"></i></span>
                        <input type="hidden" name="pemberdayaan" value="1">
                        <input name="q" type="text" class="form-control" placeholder="Cari ..." aria-describedby="addon">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group">
                        <select name="tahun" id="tahun" class="form-control">
                          <option>Tahun</option>
                          @foreach($years as $y)
                          <option value="{{ $y }}">{{ $y }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <button type="submit" class="btn btn-primary">Cari</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="col-md-6">
                  <div class="pull-right">
                    {{-- <a href="{{ url("kelahiran/import") }}" class="btn btn-info"><i class="fa fa-upload"></i> Import</a> --}}
                    <a href="{{ url("rpjm/tambah?kategori=pemberdayaan") }}" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
                  </div>
                </div>
              </div>
              <table id="posts-table" class="table table-tools table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tahun</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pemberdayaan as $p)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->year }}</td>
                    <td class="text-center">
                      <div class="form-group">
                        <a href="{{ url("rpjm/$p->id/ubah") }}" class="btn btn-warning" style="margin-bottom:0"> Ubah</a>
                        <button type="submit" class="btn btn-danger delete-button" data-id="{{ $p->id }}" data-nama="{{ $p->title }}" data-toggle="modal" data-target="#modal-confirm">Hapus</button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
              <div class="pull-right">
                {{ $pemberdayaan->appends($_GET)->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Untuk menambahkan js script / file dan modal --}}
@section('page-footers')
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan menghapus RPJM dengan judul <span id="nama">-</span>?
        </div>
        <div class="modal-footer">
          <form action="#" method="POST" id="form-delete">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            @csrf
            <button type="submit" class="btn btn-danger" id="delete-confirm">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.delete-button').on('click', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var link =  '/rpjm/' + id + '/hapus';

        $('#nama').text(nama);

        $('#form-delete').attr('action', link);
      });

      $('#delete-confirm').on('click', function() {
        $('#modal-confirm').modal('hide');
      });
    });
  </script>
@endsection