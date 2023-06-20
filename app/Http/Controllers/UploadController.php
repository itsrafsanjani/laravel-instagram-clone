<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $medias = Media::paginate();

        return view('partials.uploads', compact('medias'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

        $media = Media::create([
            'file_name' => $request->file('file')->getClientOriginalName(),
            'mime_type' => $request->file('file')->getMimeType(),
            'disk' => config('filesystems.default'),
            'size' => $request->file('file')->getSize(),
            'path' => $request->file('file')->store('media'),
        ]);

        return response()->json($media, 201);
    }
}
