@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 p-md-5 px-5 py-2">
                <img
                    src="{{ $user->profile->profileImage() }}"
                    class="rounded-circle w-100" alt="{{ $user->username }}">
            </div>
            <div class="col-md-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <div class="d-flex align-items-center">
                        <div class="h4">{{ $user->username }}</div>

                        @if(auth()->user()->username != $user->username)
                            <follow-button username="{{ $user->username }}" follows="{{ $follows }}"></follow-button>
                        @endif
                    </div>

                    @can('update', $user->profile)
                        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-secondary">Add New Post</a>
                    @endcan

                </div>

                @can('update', $user->profile)
                    <div class="my-2">
                        <a href="{{ route('profiles.edit', $user) }}" class="btn btn-sm btn-secondary">Edit Profile</a>
                    </div>
                @endcan

                <div class="d-flex">
                    <div class="pr-5 text-center"><strong>{{ $postCount }}</strong> posts</div>
                    <div class="pr-5 text-center"><strong>{{ $followersCount }}</strong> followers</div>
                    <div class="pr-5 text-center"><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>

        <div class="row pt-5 mx-auto">
            @forelse($user->posts as $post)
                <div class="col-md-4 pb-4">
                    <a href="{{ route('posts.show', $post) }}">
                        <img class="lazy w-100 rounded" data-src="{{ $post->image() }}" alt="{{ $post->title }}">
                    </a>
                </div>
            @empty
                <div class="col">
                    <h3 class="text-center text-muted">No posts yet!</h3>
                </div>
            @endforelse
        </div>
    </div>
@endsection
