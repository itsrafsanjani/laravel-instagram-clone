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
                                    <a href="{{ route('posts.show', $post) }}">
                                        <img class="card-img-top lazy" src="{{ asset('images/placeholder.jpg') }}"
                                            data-src="{{ $post->image() }}" alt="{{ $post->caption }}">
                                    </a>

                                    <div class="d-none">{{ $post->id }}</div>

                                    <div class="card-body @if ($post->comments_count > 1) pb-0 @endif">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <a href="{{ route('profiles.show', $post->user) }}" class="btn btn-link px-0"
                                                data-toggle="tooltip" data-html="true" title='<div class="card">
                                                                            <img class="card-img-top" src="{{ $post->user->avatar }}"  alt="{{ $post->user->name }}">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">{{ $post->user->name }}</h5>
                                                                            </div>
                                                                        </div>'>{{ $post->user->username }}</a>
                                            {{-- <like-button post-slug="{{ $post->slug }}" :user="{{ auth()->user() }}" --}}
                                            {{-- :likes="{{ $post->likes->count() }}" --}}
                                            {{-- like-status="{{ $post->isLikedBy(auth()->user()) }}"></like-button> --}}
                                            @include('likes.create')
                                        </div>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h5 class="h2 card-title mb-0">{{ $post->caption }}</h5>
                                            <small class="text-muted" data-toggle="tooltip" data-placement="top"
                                                title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</small>
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
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center text-muted">
                                            No posts yet! Follow
                                            <a href="{{ route('profiles.index') }}" class="text-primary"> someone </a>
                                            to see their photos!
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-none d-md-block order-2">
                <div class="card sticky-top laragram-sidebar">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="mr-2">
                                    <a href="{{ route('profiles.show', auth()->user()) }}">
                                        <img src="{{ auth()->user()->avatar }}"
                                            class="avatar rounded-circle" alt="{{ auth()->user()->username }}">
                                    </a>
                                </div>
                                <div>
                                    <div class="font-weight-bold">
                                        <a href="{{ route('profiles.show', auth()->user()) }}">
                                            <span class="text-dark">{{ auth()->user()->username }}</span>
                                        </a>
                                    </div>
                                    <div class="text-muted">
                                        <span
                                            title="{{ auth()->user()->created_at }}">{{ auth()->user()->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // infinite scroll
        $('ul.pagination').hide();
        $(function () {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="d-flex justify-content-center mb-5"><img src="/images/loading.gif" alt="Loading..." /></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function () {
                    $('ul.pagination').remove();

                    lazyLoading();
                }
            });
        });
    </script>
@endpush
