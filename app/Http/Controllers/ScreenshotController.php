<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ScreenshotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('screenshots.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('screenshots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     * @throws \Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => ['required', 'url'],
            'width' => ['required', 'integer', 'max:1920'],
            'height' => ['required', 'integer', 'max:1080'],
        ]);

        $imageNameAndPath = 'screenshots/' . Str::uuid() . '.jpg';

        $imageContents = Browsershot::url($request->url)
            ->setNodeBinary('C:\Progra~1\nodejs\node.exe')
            ->setScreenshotType('jpeg', 100)
            ->windowSize($request->width, $request->height)
            ->screenshot();

        Storage::put($imageNameAndPath, $imageContents);
        $path = Storage::url($imageNameAndPath);

        if (! $path) {
            return back()->with([
                'status' => 'error',
                'message' => 'Screenshot failed!'
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Screenshot successfully!',
            'link' => $path,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
