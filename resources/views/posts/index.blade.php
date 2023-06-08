@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-1">
                <div class="infinite-scroll">
                    @forelse($posts as $post)
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <div class="card single-post">
                                    <div
                                        class="card-header px-3 py-2 py-md-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            {{-- Avatar --}}
                                            <a href="{{ route('users.show', $post->user) }}"
                                               data-pjax
                                               class="avatar avatar-sm rounded-circle">
                                                <img alt="{{ $post->user->name }}" src="{{ $post->user->avatar }}">
                                            </a>
                                            <a href="{{ route('users.show', $post->user) }}"
                                               data-pjax
                                               class="mx-2">
                                                <h4 class="mb-0">{{ $post->user->username }}</h4>
                                            </a>
                                        </div>

                                        {{-- ellipsis trigger modal --}}
                                        <button type="button"
                                                class="btn btn-outline-neutral btn-icon-only rounded-circle text-gray"
                                                data-toggle="modal" data-target="#ellipsis{{ $post->id }}">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>

                                        {{-- ellipsis modal --}}
                                        <div class="modal fade" id="ellipsis{{ $post->id }}" tabindex="-1"
                                             aria-labelledby="ellipsis{{ $post->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="list-group text-center">
                                                        <a href="#"
                                                           class="list-group-item list-group-item-action text-danger">
                                                            {{ __('Report') }}
                                                        </a>
                                                        <a href="#"
                                                           class="list-group-item list-group-item-action text-danger">
                                                            {{ __('Unfollow') }}
                                                        </a>
                                                        <a href="{{ route('posts.show', $post) }}"
                                                           class="list-group-item list-group-item-action">
                                                            {{ __('Go to post') }}
                                                        </a>
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            {{ __('Share to...') }}
                                                        </a>
                                                        <input
                                                            class="form-control remove-focus list-group-item list-group-item-action"
                                                            id="postLink{{ $post->id }}"
                                                            value="{{ url('posts', $post) }}">
                                                        <a href="#"
                                                           class="clipboard list-group-item list-group-item-action"
                                                           data-clipboard-target="#postLink{{ $post->id }}">
                                                            {{ __('Copy Link') }}
                                                        </a>
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            {{ __('Embed') }}
                                                        </a>
                                                        <a href="#" class="list-group-item list-group-item-action"
                                                           data-dismiss="modal">
                                                            {{ __('Cancel') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="owl-carousel">
                                            @php $images = $post->getMedia('posts') @endphp
                                            @forelse($images as $image)
                                                <img class="card-img rounded-0 owl-lazy"
                                                     src="{{ asset('images/placeholder.jpg') }}"
                                                     data-src="{{ $image->getUrl('square') }}"
                                                     alt="{{ $post->caption }}">
                                            @empty

                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="d-none">{{ $post->id }}</div>

                                    <div class="card-body p-3 p-md-4 @if ($post->comments_count > 1) pb-0 @endif">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex">
                                                <a href="{{ route('users.show', $post->user) }}"
                                                   data-pjax
                                                   class="btn btn-link px-0 py-0">
                                                    {{ $post->user->username }}
                                                </a>
                                                <a class="text-sm text-muted text-center ml-2 mb-0"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ $post->created_at }}">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </a>
                                            </div>
                                            {{-- <like-button post-slug="{{ $post->slug }}" :user="{{ auth()->user() }}" --}}
                                            {{-- :likes="{{ $post->likers_count }}" --}}
                                            {{-- like-status="{{ $post->isLikedBy(auth()->user()) }}"></like-button> --}}
                                            @include('likes.create')
                                        </div>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <p class="card-title mb-0 text-sm text-break text-justify">{{ $post->caption }}</p>
                                        </div>
                                    </div>

                                    <!-- Comments -->
                                @include('comments.index', $post)
                                <!-- Comments End -->

                                    <!-- New Comment Box -->
                                @include('comments.create')
                                <!-- New Comment Box End -->
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row justify-content-center">
                            <div class="col-md-10 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center text-muted mb-0">
                                            {{ __('No posts yet!') }}
                                            <a href="{{ route('users.index') }}"
                                               data-pjax
                                               class="text-primary">
                                                {{ __('Follow someone to see their photos!') }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-center text-muted">{{ __('Posts you may like') }}</h3>

                        @include('posts._suggested-posts', $suggestedPosts)
                    @endforelse

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>

            @include('posts._sidebar')
        </div>
    </div>
@endsection
