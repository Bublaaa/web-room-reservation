<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reservation</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app">
        <main class="w-full h-screen">
            @yield('content')
        </main>
    </div>
</body>

</html>