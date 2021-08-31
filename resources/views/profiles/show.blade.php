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
                            {{-- <follow-button username="{{ $user->username }}" follows="{{ $follows }}"></follow-button> --}}
                            <button class="btn btn-sm btn-primary ml-4" id="followUnfollowButton"
                                    data-username="{{ $user->username }}">
                                {{ $follows ? 'Unfollow' : 'Follow' }}
                            </button>
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
                    <div class="pr-5 text-center">
                        @if($followersCount > 0)
                            <a href="{{ route('profiles.followers', $user->username) }}">
                                <strong id="followersCount">{{ $followersCount }}</strong> followers
                            </a>
                        @else
                            <strong id="followersCount">{{ $followersCount }}</strong> followers
                        @endif
                    </div>
                    <div class="pr-5 text-center">
                        @if($followingCount > 0)
                            <a href="{{ route('profiles.followings', $user->username) }}">
                                <strong id="followingCount">{{ $followingCount }}</strong> following
                            </a>
                        @else
                            <strong id="followingCount">{{ $followingCount }}</strong> following
                        @endif
                    </div>
                </div>
                <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="{{ $user->profile->url }}" target="_blank">{{ $user->profile->url }}</a></div>
            </div>
        </div>

        <div class="row pt-5 mx-auto">
            @forelse($user->posts as $post)
                <div class="col-md-4 pb-4">
                        <img type="button" class="lazy w-100 rounded" src="{{ asset('images/placeholder.jpg') }}"
                             data-src="{{ $post->image() }}" alt="{{ $post->title }}" data-toggle="modal" data-target="#post{{ $post->id }}">

                    {{-- Modal --}}
                    <div class="modal fade" id="post{{ $post->id }}" tabindex="-1" aria-labelledby="post{{ $post->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="post{{ $post->id }}Label">{{ $post->caption }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="lazy w-100 rounded" src="{{ asset('images/placeholder.jpg') }}"
                             data-src="{{ $post->image() }}" alt="{{ $post->title }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="window.open('{{ route('posts.show', $post) }}')">
                                    Details
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center text-muted">No posts yet!</h3>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
