<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 text-black antialiased font-sans min-h-screen flex flex-col">
    <nav class="bg-green-700 text-black shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('tasks.index', [], false) }}" class="text-xl font-bold tracking-wide">Taskly</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('tasks.create', [], false) }}" class="bg-white text-black px-4 py-2 rounded-lg font-semibold hover:bg-green-50 transition">+ New Task</a>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-8 flex-grow w-full">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-green-50 border-t border-green-200 py-4 text-center text-sm text-black">
        WST21-PM-2026-SF | Taskly
    </footer>
</body>
</html>