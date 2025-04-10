<?php

use App\Http\Controllers\InputController;
use App\Http\Controllers\AttachedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/input-form', [InputController::class, 'showFormInput'])->name('input.form');
Route::post('/process-input', [InputController::class, 'processInput'])->name('process.input');

Route::get('/email', function () {
    return view('mail.contact2');
})->name('emailPreview');

Route::get('/attachment/{filename}', [AttachedController::class, 'showAttachedFiles'])->name('show.attachment')->middleware('signed');
