<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PixController;

Route::post('/pix/qr-code', [PixController::class, 'generateQrCode']);
