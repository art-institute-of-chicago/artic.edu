<?php

namespace App\Http\Controllers;

use App\Models\SeamlessImage;
use A17\Twill\Models\File;
use DB;
use Illuminate\Http\Request;

class SeamlessImagesController extends Controller
{
    public function byFile($file_id)
    {
        // If no images found has been uploaded before, upload now
        if (SeamlessImage::where('zip_file_id', $file_id)->count() === 0) {
            $file = File::findOrFail($file_id);
            app('App\Observers\FileObserver')->handleImageSequenceZip($file);
        }
        
        $images = SeamlessImage::where('zip_file_id', $file_id)->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => 'https://' . config('twill.imgix_source_host') . '/seq/' . $image->file_name,
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
