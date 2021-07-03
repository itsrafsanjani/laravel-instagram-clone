<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::with([
            'user', 'user.profile', 'likes', 'user.likes', 'comments' => function ($query) {
                $query->with('commentator', 'commentator.profile')->latest()->limit(2);
            }
        ])
            ->withCount('comments')
            ->whereIn('user_id', $users)
            ->latest()
            ->paginate(Post::PAGINATE_COUNT);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $data = request()->validate([
            'caption' => 'required|max:255',
            'image' => 'required|image',
        ]);
//        $imagePath = request('image')->store('uploads', 'public');
//
//        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1080, 1080, function ($constraint) {
//            $constraint->upsize();
//        });
//        $image->save();

        /**
         * Cloudinary
         */
        $imagePath = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'laragram/images',
            'transformation' => [
                'background' => 'white',
                'height' => 1080,
                'width' => 1080,
                'crop' => 'pad'
            ]
        ])->getSecurePath();

//        $width = 1080;
//        $height = 1080;
//
//        $image = $request->file('image');
//        $extension = $image->getClientOriginalExtension();
//        $imageName = Str::uuid() . '.' . $extension;
//        $imagePath = $image->storeAs('images', $imageName, 'uploads');
//        $img = Image::make(public_path("uploads/{$imagePath}"));
//
//        // Resized image
//        $img->resize($width, $height, function ($constraint) {
//            $constraint->aspectRatio();
//        });
//        // Canvas image
//        $canvas = Image::canvas($width, $height, '#ffffff');
//        $canvas->insert($img, 'center');
//        $canvas->save(public_path("uploads/{$imagePath}"));
//        $imagePath = '/uploads/images/' . $imageName;

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
        $post->load([
            'comments' => function ($query) {
                $query->with('commentator', 'commentator.profile')->latest();
            }
        ])->loadCount('comments');

        return view('posts.show', compact('post'));
    }

    /**
     * @throws Exception
     */
    public function destroy(Post $post)
    {
        $postImage = public_path('/storage/' . $post->image);

        if (file_exists($postImage)) {
            @unlink($postImage);
        }

        $post->delete();

        return redirect(route('profiles.show', auth()->user()));
    }

    public function like(Post $post): JsonResponse
    {
        $likeCheck = Like::where(['user_id' => auth()->id(), 'post_id' => $post->id])->first();

        if ($likeCheck) {
            if ($likeCheck->status == true) {
                $likeCheck->update(['status' => 0]);

                return response()->json([
                    'data' => [
                        'status' => 'deleted',
                        'like_count' => $post->likes()->count()
                    ],
                    'message' => 'Success!'
                ]);
            } else {
                $likeCheck->update(['status' => 1]);
                return response()->json([
                    'data' => [
                        'status' => 'liked',
                        'like_count' => $post->likes()->count()
                    ],
                    'message' => 'Success!'
                ]);
            }

        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'status' => 1
            ]);
            return response()->json([
                'data' => [
                    'status' => 'liked',
                    'like_count' => $post->likes()->count()
                ],
                'message' => 'Success!'
            ]);
        }
    }
}
