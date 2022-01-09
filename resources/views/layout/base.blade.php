<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
    <title>Profile App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">

    <script src="{{url('/js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/jquery.slim.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
</head>
<body>
    @include('layout.top_header')
    @yield('body')
    @yield('script')
</body>
</html>
