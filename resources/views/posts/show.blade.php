@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-3">
                <img src="/storage/{{ $post->image }}" class="w-100 rounded">
            </div>
            <div class="col-md-4">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="pr-3">
                            <a href="{{ route('profiles.show', $post->user) }}">
                                <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle w-100"
                                     style="max-width: 40px;">
                            </a>
                        </div>
                        <div>
                            <div class="font-weight-bold">
                                <a href="{{ route('profiles.show', $post->user) }}">
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                                <a href="#" class="pl-3">Follow</a>
                            </div>
                            <div class="text-muted">
                                <span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @can('update', $post->user->profile)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="ml-3"
                                  onsubmit="return confirm('Are you sure to delete the post?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>

                    <hr>

                    <p>
                    <span class="font-weight-bold">
                        <a href="{{ route('profiles.show', $post->user) }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span> {{ $post->caption }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
