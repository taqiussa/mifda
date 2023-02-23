<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Refresh CSRF Token -->
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <!-- Logo -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" sizes="16x16" />

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt !important;
            margin-top: 1cm !important;
            margin-left: 1cm !important;
            margin-right: 1cm !important;
            margin-bottom: 2cm !important;
        }

        @page {
            margin: 0cm 0cm !important;
        }

        footer {
            position: fixed !important;
            bottom: 1cm !important;
            left: 1cm !important;
            right: 0cm !important;
            font-size: 11pt !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased">

    <!-- Main Content -->
    <div class="px-2 container-fluid">

        <main>

            @yield('content')

        </main>

    </div>


</body>

</html>
