@extends('layouts.app')

@section('content')
    <div class="container infinite-scroll">
        @forelse($posts as $post)
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card" style="box-shadow: 0 1px 2px #00000033;">
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="card-img-top lazy" src="{{ asset('images/placeholder.jpg') }}"
                                 data-src="{{ $post->image() }}" alt="{{ $post->caption }}">
                        </a>

                        <div class="d-none">{{ $post->id }}</div>

                        <div class="card-body @if($post->comments_count > 1 ) pb-0 @endif">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <a href="{{ route('profiles.show', $post->user) }}"
                                   class="btn btn-link px-0"
                                   data-toggle="tooltip" data-html="true" title='<div class="card">
                                        <img class="card-img-top" src="{{ $post->user->profile->profileImage() }}"  alt="{{ $post->user->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $post->user->name }}</h5>
                                        </div>
                                    </div>'>{{ $post->user->username }}</a>
                                {{--                                <like-button post-slug="{{ $post->slug }}" :user="{{ auth()->user() }}"--}}
                                {{--                                             :likes="{{ $post->likes->count() }}"--}}
                                {{--                                             like-status="{{ $post->isLikedBy(auth()->user()) }}"></like-button>--}}
                                @include('posts.likes.store')
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h5 class="h2 card-title mb-0">{{ $post->caption }}</h5>
                                <small class="text-muted" data-toggle="tooltip" data-placement="top"
                                       title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        <!-- Comments -->
                    @include('posts.comments.index', $post)
                    <!-- Comments End -->

                        <!-- New Comment Box -->
                    @include('posts.comments.create')
                    <!-- New Comment Box End -->
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <h3 class="text-center">
                        No posts yet! Follow
                        <a href="{{ route('profiles.index') }}"> someone </a>
                        to see their photos!
                    </h3>
                </div>
            </div>
        @endforelse

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
