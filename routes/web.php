<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/generate-qrcode', function (Request $request) {
    // Validação básica
    $request->validate([
        'qrcode_text' => 'required|string',
        'logo' => 'nullable|image|max:2048',
        'style' => 'nullable|string|in:square,round,dot', // Campo para estilo
        'size' => 'nullable|integer|min:100|max:500', // Campo para tamanho
        'density' => 'nullable|string|in:L,M,Q,H', // Densidade do QR code
    ]);

    // Tamanho do QR code (padrão: 250)
    $size = $request->input('size', 250);

    // Definir o writer
    $writer = new PngWriter();

    // Configuração do nível de correção de erro
    $density = $request->input('density', 'M');
    switch ($density) {
        case 'L':
            $errorLevel = ErrorCorrectionLevel::Low;
            break;
        case 'M':
            $errorLevel = ErrorCorrectionLevel::Medium;
            break;
        case 'Q':
            $errorLevel = ErrorCorrectionLevel::Quartile;
            break;
        case 'H':
        default:
            $errorLevel = ErrorCorrectionLevel::High;
            break;
    }

    // Iniciar o builder
    $builder = Builder::create()
        ->writer($writer)
        ->data($request->qrcode_text)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel($errorLevel)
        ->size($size)
        ->margin(1);

    // Configuração do estilo - vamos tentar o RoundBlockSizeMode
    $style = $request->input('style', 'square');
    if ($style == 'round') {
        $builder->roundBlockSizeMode(RoundBlockSizeMode::Margin);
    }

    // Verificar se o usuário escolheu cor customizada
    if ($request->has('custom_color') && $request->input('custom_color')) {
        $r = $request->input('color_r', 0);
        $g = $request->input('color_g', 0);
        $b = $request->input('color_b', 0);

        $builder->foregroundColor(new Color($r, $g, $b));
    }

    // Se uma logo foi enviada, processar e adicionar ao QR code
    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        // Armazenar temporariamente o arquivo
        $logoPath = $request->file('logo')->store('temp', 'public');
        $fullLogoPath = Storage::disk('public')->path($logoPath);

        // Tamanho da logo em relação ao QR code (padrão: 0.2 = 20%)
        $logoSize = $request->input('logo_size', 0.2);
        $logoWidth = intval($size * $logoSize);

        // Adicionar logo ao builder
        $builder->logoPath($fullLogoPath)
            ->logoResizeToWidth($logoWidth)
            ->logoPunchoutBackground(true);
    }

    // Construir o QR code
    $result = $builder->build();

    // Obter a string do QR code
    $pngData = $result->getString();

    // Converter para Data URI
    $qrcodeDataUri = 'data:image/png;base64,' . base64_encode($pngData);

    // Limpar arquivo temporário da logo, se existir
    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        Storage::disk('public')->delete($logoPath);
    }

    return redirect()->back()->with('qrcode', $qrcodeDataUri);
})->name('generate.qrcode');
