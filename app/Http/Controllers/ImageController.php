<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function showUploadForm()
{
    return view('upload');
}

public function upload(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:2048',
    ]);
    $image = $request->file('image');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    $croppedImage = Image::make($image)->resize(300, 300, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path('uploads/' . $filename));
    return response()->json(['status' => 'success', 'filename' => $filename]);
}


}
