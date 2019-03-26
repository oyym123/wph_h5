<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/weui.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/jiazai.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@section('content')
@show
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}">


</script>
</body>
</html>
