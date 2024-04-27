<?php

use App\Http\Controllers\PDFBucketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pdf_bucket');
});

Route::post('/pdf_bucket', [PDFBucketController::class, 'upload'])->name("upload");
Route::get('/download/{filename}', [PDFBucketController::class, 'download'])->name("download");