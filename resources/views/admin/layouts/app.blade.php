<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/admin.css') }}">
</head>
<body class="app sidebar-mini rtl">
<!-- Navbar-->
@include('admin.layouts.header')
<!-- Sidebar menu-->
@include('admin.layouts.sidebar')

<main class="app-content" id="app">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-circle-o"></i> @yield('title')</h1>
            <p>@yield('desc')</p>
        </div>
    </div>

    <flash-message-component></flash-message-component>
    @include('layouts.flash-messages')

    @yield('content')

</main>

@include('admin.layouts.footer')
</body>
</html>
