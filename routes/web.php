<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShortLinkController::class, 'create'])->name('shortlink.create');
Route::post("/shortlinks", [ShortLinkController::class, 'store'])->name('shortlinks.store');
Route::get("/{shortlink:slug}", [ShortLinkController::class, 'show'])->name('shortlinks.show');
