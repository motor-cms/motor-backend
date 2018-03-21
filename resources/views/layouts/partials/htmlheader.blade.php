<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('motor-backend-project.name') }} Backend">
    <meta name="author" content="Reza Esmaili">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="">
    <title>{{ config('motor-backend-project.name') }} Backend - @yield('htmlheader_title', 'Your title here') </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('view_styles')

<!-- Main styles for this application -->
    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
</head>
