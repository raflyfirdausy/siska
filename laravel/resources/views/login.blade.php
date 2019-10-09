@extends('layouts.master')

@section('tab-title')
    Masuk |
@endsection

@section('headers')
    <!-- BEGIN MANDATORY STYLE -->
    <link href="{{ asset('css/icons/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    <link href="#" rel="stylesheet" id="theme-color">
    <!-- END  MANDATORY STYLE -->
    <script src="{{ asset('plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
@endsection

@section('body')
    <!-- BEGIN LOGIN BOX -->
    <div class="container" id="login-block">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <p>Username atau Password Anda salah!</p>
                </div>
                @endif
                <div class="login-box" style="margin-top: 0px; background-color:rgb(255, 255, 255)">
                    <div class="login-logo">
                        <img src="{{ asset('img/account/login-logo.png') }}" alt="Company Logo">
                    </div>
                    <hr>
                    <div class="login-form">
                        <!-- BEGIN ERROR BOX -->
                        <div class="alert alert-danger hide">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h4>Error!</h4>
                            Your Error Message goes here
                        </div>
                        <!-- END ERROR BOX -->
                        <form action="{{ url('/login') }}" method="POST">
                            @csrf
                            <input type="text" name="username" placeholder="Username" class="input-field form-control user" />
                            <input type="password" name="password" placeholder="Password" class="input-field form-control password" />
                            <div class="div-login" style="margin:auto;text-align:center">
                                <button style="display: inline;" id="submit-form" class="btn btn-login" data-style="expand-left">login</button>
                            </div> 
                            
                        </form>
                        {{-- <div class="login-links">
                            <a class="error" href="password_forgot.html">Lupa akun?</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOCKSCREEN BOX -->
@endsection

@section('footers')
    <!-- BEGIN MANDATORY SCRIPTS -->
    <script src="{{ asset('plugins/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui-1.11.2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mobile/jquery.mobile-1.4.2.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.cookie.min.js') }}" type="text/javascript"></script>
    <!-- END MANDATORY SCRIPTS -->
@endsection

