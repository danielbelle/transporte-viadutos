<?php

use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/input-form', [InputController::class, 'showFormInput'])->name('input.form');
Route::post('/process-input', [InputController::class, 'processInput'])->name('process.input');
Route::get('/email', function () {
    return view('mail.contact2');
})->name('emailPreview');
