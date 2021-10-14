@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 p-md-5 px-5 py-2">
                <img
                    src="{{ $user->avatar }}"
                    class="rounded-circle w-100" alt="{{ $user->username }}">
            </div>
            <div class="col-md-9 pt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex">
                        <div>
                            <div class="text-lg font-weight-bold">{{ $user->username }}</div>
                        </div>

                        @if(auth()->user()->username != $user->username)
                            {{-- <follow-button username="{{ $user->username }}" follows="{{ $user->has_followed }}"></follow-button> --}}
                            <button class="btn btn-sm btn-primary ml-4" id="followUnfollowButton"
                                    data-username="{{ $user->username }}">
                                {{ $user->has_followed ? __('Unfollow') : __('Follow') }}
                            </button>
                        @endif

                        @can('update', $user)
                            <div class="ml-4">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-secondary">
                                    {{ __('Edit Profile') }}
                                </a>
                            </div>
                        @endcan
                    </div>

                    @can('update', $user)
                        <div>
                            <a href="{{ route('posts.create') }}" class="btn btn-sm btn-secondary">
                                {{ __('Add New Post') }}
                            </a>
                        </div>
                    @endcan

                </div>

                <div class="d-flex mb-3">
                    <div class="text-center"><strong>{{ $user->posts_count }}</strong> {{ __('posts') }}</div>
                    <div class="pl-5 text-center">
                        @if($user->followers_count > 0)
                            <a href="{{ route('users.followers', $user->username) }}">
                                <strong id="followersCount">{{ $user->followers_count }}</strong> {{ __('followers') }}
                            </a>
                        @else
                            <strong id="followersCount">{{ $user->followers_count }}</strong> {{ __('followers') }}
                        @endif
                    </div>
                    <div class="pl-5 text-center">
                        @if($user->followings_count > 0)
                            <a href="{{ route('users.followings', $user->username) }}">
                                <strong id="followingsCount">{{ $user->followings_count }}</strong> {{ __('following') }}
                            </a>
                        @else
                            <strong id="followingsCount">{{ $user->followings_count }}</strong> {{ __('following') }}
                        @endif
                    </div>
                </div>
                <div class="pt-4">
                    @if ($user->name)
                        <div class="font-weight-bold">{{ $user->name }}</div>
                    @endif
                    @if ($user->bio)
                        <div>{{ $user->bio }}</div>
                    @endif
                    @if ($user->website)
                        <div><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row pt-5 mx-auto">
            @forelse($user->posts as $post)
                @include('posts._single-post-with-modal')
            @empty
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-muted">{{ __('No posts yet!') }}</h3>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
