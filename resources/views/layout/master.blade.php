<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Decor</title>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Color Theme (Bronze/Brown) */
        .bg-decor { background-color: #B47B49; }
        .bg-decor:hover { background-color: #986538; }
        .text-decor { color: #B47B49; }
        .border-decor { border-color: #B47B49; }
        .btn-tambah {
            background-color: #B47B49;
            color: white;
            padding: 10px 20px;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            transition: background-color 0.15s;
        }

        .btn-tambah:hover {
            background-color: #986538;
        }

        .badge-utama {
            background-color: #fcd34d;
            color: #78350f;
            padding: 2px 8px;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: background-color 0.15s;
        }

        .btn-edit {
            color: #9ca3af;
            border: 1px solid #e5e7eb;
        }

        .btn-edit:hover {
            background-color: #f3f4f6;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background-color: #dc2626;
        }

        .btn-submit {
            background-color: #d97706;
            color: white;
            padding: 10px 20px;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            transition: background-color 0.15s;
        }

        .btn-submit:hover {
            background-color: #b45309;
        }

        .btn-back {
            background-color: #6b7280;
            color: white;
            padding: 10px 20px;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            transition: background-color 0.15s;
        }

        .btn-back:hover {
            background-color: #4b5563;
        }
    </style>
    @yield('add-css')
</head>

<body class="font-sans">
    @include('layout.navbar')
    @yield('content')
    @include('layout.footer')
</body>

</html>
