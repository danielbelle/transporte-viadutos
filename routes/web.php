<?php

use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('home');
});

Route::get('/input-form', [InputController::class, 'showFormInput'])->name('input.form');
Route::post('/process-input', [InputController::class, 'processInput'])->name('process.input');

Route::get('/email', function () {
    return view('mail.contact2');
})->name('emailPreview');

Route::get('/private-attachment/{filename}', function ($filename) {
    // Verificar token na URL
    if (!request()->hasValidSignature()) {
        abort(403, 'URL inválida ou expirada');
    }
    // Verificar se é uma extensão de imagem permitida
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {
        abort(403, 'Tipo de arquivo não permitido');
    }
    $path = "{$filename}";
    // Verificar se o arquivo existe

    // Retornar a imagem
    if (!Storage::disk('local')->exists("attachments/" . $filename)) {
        abort(404);
    }

    return response()->file(storage_path("app/private/attachments/{$path}"));
})->name('private.attachment')->middleware('signed');
