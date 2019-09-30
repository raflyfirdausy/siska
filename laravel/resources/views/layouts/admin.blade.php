@extends('layouts.master')

@section('headers')
  <!-- BEGIN MANDATORY STYLE -->
  <link href="{{ asset('css/icons/icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/plugins.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/style.min.css')}}" rel="stylesheet">
  <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
  <link href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet">
  <link href="#" rel="stylesheet" id="theme-color">
  @yield('page-headers')
  <!-- END  MANDATORY STYLE -->
  <script src="{{ asset('plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
@endsection

@section('body')
  @component('components.navbar')
  @endcomponent
  <!-- BEGIN WRAPPER -->
  <div id="wrapper">
    @component('components.sidebar')
    @endcomponent
    <!-- BEGIN MAIN CONTENT -->
    <div id="main-content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3>
          @yield('page-title')
        </h3>
      </div>
      @yield('page-content')
    </div>
    <!-- END MAIN CONTENT -->
  </div>
  <!-- END WRAPPER -->
@endsection

@section('footers')
  <!-- BEGIN MANDATORY SCRIPTS -->
  <script src="{{ asset('plugins/jquery-1.11.1.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-migrate-1.2.1.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui-1.11.2.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-mobile/jquery.mobile-1.4.2.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap-select/bootstrap-select.js') }}"></script>
  <script src="{{ asset('plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
  <script src="{{ asset('plugins/mmenu/js/jquery.mmenu.min.all.js') }}"></script>
  <script src="{{ asset('plugins/nprogress/nprogress.js') }}"></script>
  <script src="{{ asset('plugins/charts-sparkline/sparkline.min.js') }}"></script>
  <script src="{{ asset('plugins/breakpoints/breakpoints.js') }}"></script>
  <script src="{{ asset('plugins/numerator/jquery-numerator.js') }}"></script>
  <script src="{{ asset('plugins/jquery.cookie.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/parsley/parsley.min.js') }}"></script>
  <script src="{{ asset('plugins/parsley/parsley.extend.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
  @if ($errors->any())
  <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Terjadi Kesalahan!</h4>
      </div>
      <div class="modal-body">
        <ul>
        @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
      </div>
    </div>
    </div>
    <script>
    $('#modal-alert').modal();
    </script>
  @endif

  @if (Session::has('success'))
  <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
          </div>
          <div class="modal-body">
            {{ Session::get('success') }}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('#modal-alert').modal();
    </script>
  @endif
  
  @yield('page-footers')
  <!-- END MANDATORY SCRIPTS -->
  <script src="{{ asset('js/application.js') }}"></script>
@endsection