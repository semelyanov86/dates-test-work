<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dates</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 p-6">
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Dates</h1>
    @foreach ($dates as $date => $items)
        <div class="mb-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full text-left" onclick="toggleCollapse('{{ $date }}')">
                {{ $date }}
            </button>
            <div id="collapse-{{ $date }}" class="hidden bg-white border border-gray-200 rounded p-4">
                @foreach ($items as $item)
                    <div class="mb-2">
                        <p class="text-gray-700"><strong>Name:</strong> {{ $item->name }}</p>
                        <p class="text-gray-700"><strong>ID:</strong> {{ $item->id }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
<script>
    function toggleCollapse(date) {
        const element = document.getElementById('collapse-' + date);
        element.classList.toggle('hidden');
    }
</script>
</body>
</html>
