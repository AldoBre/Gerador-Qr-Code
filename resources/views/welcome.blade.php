<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code Elegante com Logo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-800 max-w-lg w-full">
            <h1 class="text-2xl font-bold mb-4 text-center">Gerador de QR Code Elegante</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('generate.qrcode') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="qrcode_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Texto ou Link
                    </label>
                    <input
                        type="text"
                        name="qrcode_text"
                        id="qrcode_text"
                        class="border p-2 w-full rounded dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        placeholder="Insira o texto ou link"
                        required
                        value="{{ old('qrcode_text') }}"
                    >
                </div>

                <!-- Seção de Aparência -->
                <div class="mb-4 border rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-medium mb-3">Aparência do QR Code</h3>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Tamanho -->
                        <div>
                            <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tamanho
                            </label>
                            <select
                                name="size"
                                id="size"
                                class="border p-2 w-full rounded dark:bg-gray-600 dark:text-white dark:border-gray-500"
                            >
                                <option value="150">Pequeno (150px)</option>
                                <option value="250" selected>Médio (250px)</option>
                                <option value="350">Grande (350px)</option>
                                <option value="450">Extra Grande (450px)</option>
                            </select>
                        </div>

                        <!-- Estilo -->
                        <div>
                            <label for="style" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Estilo dos Módulos
                            </label>
                            <select
                                name="style"
                                id="style"
                                class="border p-2 w-full rounded dark:bg-gray-600 dark:text-white dark:border-gray-500"
                            >
                                <option value="square">Quadrados (Padrão)</option>
                                <option value="dot">Pontilhado (Elegante)</option>
                                <option value="round">Arredondado (Moderno)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- Densidade -->
                        <div>
                            <label for="density" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Densidade (Módulos)
                            </label>
                            <select
                                name="density"
                                id="density"
                                class="border p-2 w-full rounded dark:bg-gray-600 dark:text-white dark:border-gray-500"
                            >
                                <option value="L">Baixa (Menos Módulos)</option>
                                <option value="M" selected>Média (Padrão)</option>
                                <option value="Q">Alta</option>
                                <option value="H">Muito Alta (Mais Módulos)</option>
                            </select>
                        </div>

                        <!-- Tamanho da Logo -->
                        <div>
                            <label for="logo_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tamanho da Logo
                            </label>
                            <select
                                name="logo_size"
                                id="logo_size"
                                class="border p-2 w-full rounded dark:bg-gray-600 dark:text-white dark:border-gray-500"
                            >
                                <option value="0.15">Pequeno (15%)</option>
                                <option value="0.2" selected>Médio (20%)</option>
                                <option value="0.25">Grande (25%)</option>
                                <option value="0.3">Muito Grande (30%)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Olhos Redondos -->
                    <div class="flex items-center mb-4">
                        <input
                            type="checkbox"
                            name="round_eyes"
                            id="round_eyes"
                            value="1"
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="round_eyes" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Usar olhos circulares (cantos arredondados)
                        </label>
                    </div>
                </div>

                <!-- Upload de Logo -->
                <div class="mb-4">
                    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Logo (opcional)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-7">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="pt-1 text-sm text-gray-400 dark:text-gray-500" id="file-name">
                                    Arraste ou clique para adicionar logo
                                </p>
                            </div>
                            <input type="file" name="logo" id="logo" class="hidden" accept="image/*" onchange="updateFileName(this)" />
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        PNG, JPG, GIF até 2MB (recomendado: imagem quadrada)
                    </p>
                </div>

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition">
                    Gerar QR Code
                </button>
            </form>

            @if (session('qrcode'))
                <div class="mt-6 mb-4 flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-3 text-center">QR Code Gerado</h2>
                    <div class="border p-4 rounded bg-white mb-4">
                        <img src="{{ session('qrcode') }}" alt="QR Code" class="mx-auto">
                    </div>
                    <div class="flex space-x-2">
                        <a
                            href="{{ session('qrcode') }}"
                            download="qrcode.png"
                            class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition flex items-center"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Baixar QR Code
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Arraste ou clique para adicionar logo';
            document.getElementById('file-name').textContent = fileName;
        }
    </script>
</body>
</html>