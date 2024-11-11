<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::post('/generate-qrcode', function (Request $request) {
    $qrcode = QrCode::format('png')
    ->size(400)
        ->margin(2)
        ->generate($request->qrcode_text);

    $qrcodeDataUri = 'data:image/png;base64,' . base64_encode($qrcode);

    return redirect()->back()->with('qrcode', $qrcodeDataUri);
})->name('generate.qrcode');

Route::get('/', action: function () {
    return view('welcome');
});


