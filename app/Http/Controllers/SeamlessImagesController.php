<?php

namespace App\Http\Controllers;

use App\Models\SeamlessImage;
use DB;
use Illuminate\Http\Request;

class SeamlessImagesController extends Controller
{
    public function byFile($file_id)
    {
        $images = SeamlessImage::where('zip_file_id', $file_id)->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => 'https://' . env('IMGIX_SOURCE_HOST', 'artic-web.imgix.net') . '/seq/' . $image->file_name,
                'frame' => $image->frame,
                'width' => $image->width,
                'height' => $image->height,
            ];
        });
        return response()->json($images)->withHeaders([
            "Access-Control-Allow-Origin" => "*",
            "Access-Control-Allow-Methods" => "GET",
            "Access-Control-Allow-Headers" => "Content-Type",
            "Access-Control-Allow-Headers" => "*",
        ]);
    }
}
