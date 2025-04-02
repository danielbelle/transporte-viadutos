<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/pdf', [PdfController::class, 'show'])->name('pdf.show');
