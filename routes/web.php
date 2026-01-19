<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeddingInvitationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wedding/create', [WeddingInvitationController::class, 'create'])->name('wedding.create');
Route::post('/wedding/store', [WeddingInvitationController::class, 'store'])->name('wedding.store');
