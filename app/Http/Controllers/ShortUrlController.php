<?php

namespace App\Http\Controllers;

use App\Models\User;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use AshAllenDesign\ShortURL\Models\ShortURL as ModelsShortURL;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $urls = auth()->user()->shortUrls()->paginate(User::PAGINATE_COUNT);

        return view('short-urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('short-urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => ['required', 'url'],
            'custom_key' => ['nullable', 'regex:/(^[A-Za-z0-9]+$)+/'],
        ]);

        $shortURLObject = $request->custom_key ?
            ShortURL::destinationUrl($request->url)->urlKey($request->custom_key)->make() :
            ShortURL::destinationUrl($request->url)->make();

        auth()->user()->shortUrls()->attach($shortURLObject['id']);

        return to_route('short-urls.index')->with([
            'status' => 'success',
            'message' => 'Short url generated successfully!',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (auth()->user()->shortUrls()->detach($id)) {
            ModelsShortURL::destroy($id);

            return to_route('short-urls.index')->with([
                'status' => 'success',
                'message' => 'Short url deleted successfully!',
            ]);
        }

        return to_route('short-urls.index')->with([
            'status' => 'error',
            'message' => 'Short url deletion failed!',
        ]);
    }
}
