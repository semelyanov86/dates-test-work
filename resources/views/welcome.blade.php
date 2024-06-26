<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload XLS File</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-md w-1/3">
    <h1 class="text-xl font-bold mb-4">Upload XLS File</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="xls_file" class="block text-gray-700">Choose XLS File:</label>
            <input type="file" name="xls_file" id="xls_file" class="mt-2 p-2 border rounded w-full">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>
</body>
</html>
