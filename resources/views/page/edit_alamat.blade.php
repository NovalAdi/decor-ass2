<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alamat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
</head>

<body class="bg-gray-50 min-h-screen p-8">

    <div class="max-w-3xl mx-auto bg-white rounded-lg p-6 sm:p-8 shadow">

        <h1 class="text-2xl font-semibold text-gray-800 mb-8">Edit Alamat</h1>

        <form action="{{ route('alamat.update', $address->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Judul Alamat</label>
                <input type="text" name="judul" required value="{{ $address->judul }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:outline-none">
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="5" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:outline-none">{{ $address->alamat }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('alamat.index') }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-submit">Update Alamat</button>
            </div>

        </form>

    </div>

</body>

</html>