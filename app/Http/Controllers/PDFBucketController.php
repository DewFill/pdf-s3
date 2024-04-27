<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Random\RandomException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PDFBucketController extends Controller
{
    /**
     * @throws RandomException
     */
    static function upload(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);


        do {
            $random_string = bin2hex(random_bytes(18));
        } while (Storage::disk("s3-local")->exists("pdf/$random_string.pdf"));


        $file = $request->file('file');
        $file->storePubliclyAs('pdf', "$random_string.pdf", 's3-local');


        return view("pdf_bucket", ["download_url" => "/download/$random_string"]);
    }


    static function download($filename): StreamedResponse
    {
        return Storage::disk("s3-local")->download("pdf/$filename.pdf");
    }
}
