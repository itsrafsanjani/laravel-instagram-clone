@extends('layouts.app')

@section('content')
    <div class="container infinite-scroll">
        @forelse($posts as $post)
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <a href="/p/{{ $post->id }}">
                            <img class="card-img-top lazy" data-src="/storage/{{ $post->image }}">
                        </a>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <a href="{{ route('profiles.show', $post->user) }}"
                                   class="btn btn-link px-0"
                                   data-toggle="tooltip" data-html="true" title='
                                   <div class="card">
                                        <img class="card-img-top" src="{{ $post->user->profile->profileImage() }}"  alt="{{ $post->user->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $post->user->name }}</h5>
                                        </div>
                                    </div>
                                   '
                                >{{ $post->user->username }}</a>
                                <i class="far fa-heart text-danger likeBtn" data-toggle="tooltip" title="Like"></i>
                            </div>
                            <h5 class="h2 card-title mb-0">{{ $post->caption }}</h5>
                            <small class="text-muted" data-toggle="tooltip" data-placement="top"
                                   title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <h3 class="text-center">No posts yet! Follow <a href="{{ route('profiles.index') }}">someone</a> to
                        see their photos!</h3>
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
