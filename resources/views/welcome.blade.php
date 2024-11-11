<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel QR Code Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-4">Gerador de QR Code</h1>
            <form action="{{ route('generate.qrcode') }}" method="POST" class="mb-4">
                @csrf
                <input type="text" name="qrcode_text" class="border p-2 w-full mb-4" placeholder="Insira o texto ou link" required>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Gerar QR Code</button>
            </form>
            @if (session('qrcode'))
                <div class="mb-4">
                    <img src="{{ session('qrcode') }}" alt="QR Code">
                </div>
                <a href="{{ session('qrcode') }}" download="qrcode.png" class="bg-green-500 text-white px-4 py-2 rounded">Baixar QR Code</a>
            @endif
        </div>
    </div>
</body>
</html>
