<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Kandor')</title>

    <link rel="stylesheet" href="{{ asset('css/reset_general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset_secciones.css') }}">

    @stack('estilos')
</head>
<body>
    @yield('contenido')
    @stack('scripts')
</body>
</html>