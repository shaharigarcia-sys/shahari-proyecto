<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="En tu hogar – Tienda de agua purificada y mineral a domicilio.">
    <meta name="theme-color" content="#176b87">
    <title>@yield('title', 'En tu hogar – Agua purificada a domicilio')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Ajustes de fuente, escala y lectura adaptable. -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>

