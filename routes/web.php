<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return view('contact');
});

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
