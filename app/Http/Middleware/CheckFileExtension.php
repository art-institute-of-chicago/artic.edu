<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * If the request is for a file with a file type we do not serve, throw a 404.
 */
class CheckFileExtension
{
    public function handle(Request $request, Closure $next): Response
    {
        $mediaExtensions = config('twill.media_library.allowed_extensions');
        $fileExtensions = config('twill.file_library.allowed_extensions');
        $allExtensions = array_unique(array_merge($mediaExtensions, $fileExtensions));

        $filename = array_last($request->segments());
        $extension = File::extension($filename);
        if ($extension && !in_array($extension, $allExtensions)) {
            abort(404);
        }

        return $next($request);
    }
}
