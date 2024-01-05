<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ env('APP_NAME','CRM-TEST') }}">
    <meta name="description" content="Jaipur Jewellery House">

    <title> 
        @hasSection('title')
            @yield('title')
        @else
            {{ env('APP_NAME', 'Jaipur Jewellery') }}
        @endif
    </title>
    <link rel="shortcut icon" href="{{ asset('assets/front/img/favicon.png') }}" type="image/x-icon" />
    <link href="{{ asset('assets/front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/helper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/style.css') }}" rel="stylesheet">
   
    @stack('styles')  

   
</head>