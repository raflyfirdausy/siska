<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js sidebar-large"> <!--<![endif]-->
<head>
    <!-- BEGIN META SECTION -->
    <meta charset="utf-8">
    <title>@yield('tab-title') Sisdes - Sistem Informasi Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="description" />
    <meta content="themes-lab" name="author" />
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <!-- END META SECTION -->
    @yield('headers')
</head>

<body>
    @yield('body')
    @yield('footers')
</body>
</html>