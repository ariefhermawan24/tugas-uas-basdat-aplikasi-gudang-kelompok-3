<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')
</body>
</html>
