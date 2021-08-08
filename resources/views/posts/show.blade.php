@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-3">
                <img src="{{ asset('images/placeholder.jpg') }}" data-src="{{ $post->image }}" class="w-100 rounded lazy" alt="{{ $post->caption }}">
            </div>
            <div class="col-md-4">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="pr-3">
                            <a href="{{ route('profiles.show', $post->user) }}">
                                <img src="{{ $post->user->profile->profileImage() }}" class="avatar rounded-circle"
                                     alt="{{ $post->user->username }}">
                            </a>
                        </div>
                        <div>
                            <div class="font-weight-bold">
                                <a href="{{ route('profiles.show', $post->user) }}">
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                            </div>
                            <div class="text-muted">
                                <span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('profiles.show', $post->user) }}" class="btn btn-primary btn-sm ml-3">View Profile</a>
                        @can('update', $post->user->profile)
                            <form action="{{ route('posts.destroy', $post) }}" method="post" class="ml-3"
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

                <!-- New Comment Box -->
            @include('posts.comments.create')
            <!-- New Comment Box End -->

                <!-- Comments -->
            @include('posts.comments.index')
            <!-- Comments End -->
            </div>
        </div>
    </div>
@endsection
