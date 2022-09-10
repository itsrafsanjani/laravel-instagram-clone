<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $users = auth()->user()->followings()->pluck('followable_id');

        $posts = Post::with([
            'media', 'user.media', 'likers.media', 'comments' => function ($query) {
                $query->with('commentator')->latest()->limit(2);
            },
        ])
            ->withCount(['comments', 'likers'])
            ->whereIn('user_id', $users)
            ->latest()
            ->paginate(Post::PAGINATE_COUNT);

        $suggestedUsers = User::whereNotIn('id', $users)
            ->where('id', '<>', auth()->id())
            ->inRandomOrder()
            ->take(10)
            ->get();

        $suggestedPosts = Post::with([
            'media', 'user.media', 'likers.media', 'comments' => function ($query) {
                $query->with('commentator')->latest()->limit(2);
            },
        ])->popularLast(Post::POPULAR_BY_DAY)->paginate(Post::PAGINATE_COUNT);
        if ($posts->count() > 0) {
            $suggestedPosts = [];
        }

        return view('posts.index', compact('posts', 'suggestedUsers', 'suggestedPosts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $post = Post::create([
                    'caption' => $request->caption,
                    'user_id' => auth()->id(),
                    'slug' => Str::random(12),
                ]);

                if ($request->hasFile('image')) {
                    $post->addMultipleMediaFromRequest(['image'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('posts');
                    });
                }
            });

            DB::commit();

            return redirect()->route('users.show', auth()->user())->with([
                'status' => 'success',
                'message' => 'Post uploaded successfully!',
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();

            return $exception;
        }

        //        $data = request()->validate([
        //            'caption' => 'required|max:255',
        //            'image' => 'required|image',
        //        ]);
        /**
         * Intervention Image
         */
        //        $imagePath = request('image')->store('uploads', 'public');
        //
        //        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1080, 1080, function ($constraint) {
        //            $constraint->upsize();
        //        });
        //        $image->save();

        //        /**
        //         * Cloudinary
        //         */
        //        $imagePath = Cloudinary::upload($request->file('image')->getRealPath(), [
        //            'folder' => 'laragram/images',
        //            'transformation' => [
        //                'background' => 'white',
        //                'height' => 1080,
        //                'width' => 1080,
        //                'crop' => 'pad'
        //            ]
        //        ])->getSecurePath();
        //
        //        $client = new SightengineClient(config('services.sightengine.user'), config('services.sightengine.secret'));
        //        $output = $client->check(['nudity'])->set_url($imagePath);
        //
        //        $user = auth()->user();
        //        if ($output->nudity->safe > 0.5 && $output->nudity->raw < 0.1) {
        //            $user->posts()->create([
        //                'slug' => Str::random(12),
        //                'caption' => $data['caption'],
        //                'image' => $imagePath,
        //            ]);
        //
        //            return redirect()->route('users.show', $user)->with([
        //                'status' => 'success',
        //                'message' => 'Post uploaded successfully!'
        //            ]);
        //        }
        //
        //        return redirect()->route('users.show', $user)->with([
        //            'status' => 'error',
        //            'message' => 'Your image contains inappropriate content!'
        //        ]);
    }

    public function show(Post $post)
    {
        SEOTools::setTitle($post->caption);
        SEOTools::setDescription($post->caption);
        SEOTools::setCanonical(route('posts.show', $post));
        SEOTools::opengraph()->setUrl(route('posts.show', $post));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage($post->getFirstMediaUrl('posts', 'meta-image'));
        SEOTools::twitter()->setSite($post->user->name);
        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::jsonLd()->addImage($post->getFirstMediaUrl('posts', 'meta-image'));

        $post->load([
            'comments' => function ($query) {
                $query->with('commentator', 'commentator')->latest();
            },
        ])->loadCount('comments', 'likers');

        $post->visit();

        return view('posts.show', compact('post'));
    }

    /**
     * @throws Exception
     */
    public function destroy(Post $post)
    {
        $postImage = public_path('/storage/'.$post->image);

        if (file_exists($postImage)) {
            @unlink($postImage);
        }

        $post->delete();

        return redirect(route('users.show', auth()->user()));
    }

    public function explore()
    {
        $posts = Post::with('media')->popularLast(Post::POPULAR_BY_DAY)->paginate(Post::PAGINATE_COUNT);

        return view('posts.explore', compact('posts'));
    }
}
