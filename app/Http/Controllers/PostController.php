<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::with('user', 'user.profile', 'likes', 'user.likes')->whereIn('user_id', $users)->latest()->paginate(20);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'caption' => 'required|max:255',
            'image' => ['required', 'image'],
        ]);

//        $imagePath = request('image')->store('uploads', 'public');
//
//        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1080, 1080, function ($constraint) {
//            $constraint->upsize();
//        });
//        $image->save();

        $imagePath = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

        $user = auth()->user();
        $user->posts()->create([
            'slug' => Str::random(12),
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect()->route('profiles.show', $user);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $postImage = public_path('/storage/' . $post->image);

        if (file_exists($postImage)) {
            @unlink($postImage);
        }

        $post->delete();

        return redirect(route('profiles.show', auth()->user()));
    }

    public function storeLike(Post $post)
    {
        $likeCheck = Like::where(['user_id' => auth()->id(), 'post_id' => $post->id])->first();

        if ($likeCheck) {
            Like::where(['user_id' => auth()->id(), 'post_id' => $post->id])->delete();
            return response('deleted');
        } else {
            $like = Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id
            ]);
            return response($like);
        }
    }
}
