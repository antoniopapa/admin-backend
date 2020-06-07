<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * @OA\Post(
     *   path="/upload",
     *   security={{"bearerAuth":{}}},
     *   tags={"Images"},
     *   @OA\Response(response="200",
     *     description="Upload Images",
     *   )
     * )
     */
    public function upload(ImageUploadRequest $request)
    {
        $file = $request->file('image');
        $name = Str::random(10);
        $url = \Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        return [
            'url' => env('APP_URL') . '/' . $url,
        ];
    }
}
