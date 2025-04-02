<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/pdf', [PdfController::class, 'show'])->name('pdf.show');

Route::get('/name-form', [NameController::class, 'showForm'])->name('name.form');
Route::post('/process-name', [NameController::class, 'processName'])->name('process.name');


Route::get('/input-form', [InputController::class, 'showFormInput'])->name('input.form');
Route::post('/process-input', [InputController::class, 'processInput'])->name('process.input');
