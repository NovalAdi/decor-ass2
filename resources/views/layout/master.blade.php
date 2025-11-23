<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Decor</title>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('add-css')
</head>

<body class="font-sans">
    @include('layout.navbar')
    @yield('content')
    @include('layout.footer')
</body>

</html>
