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
    <div id="app" class="flex flex-col">
        <div class="flex flex-row h-auto w-full mt-20">
            <div class="w-full mt-4 md:p-5">
                <main class="">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>

</html>