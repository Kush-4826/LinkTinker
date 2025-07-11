<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShortLinkController::class, 'create'])->name('shortlink.create');
