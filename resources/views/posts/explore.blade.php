@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-3 mx-auto">
            @forelse($posts as $post)
                @include('posts._single-post-with-modal')
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
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
