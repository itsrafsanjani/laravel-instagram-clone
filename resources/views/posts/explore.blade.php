@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-3 mx-auto">
            <div class="card-columns">
                    @forelse($posts as $post)
                        <div class="card single-post">
                            <img type="button" class="lazy w-100 rounded" src="{{ asset('images/placeholder.jpg') }}"
                                 data-src="{{ $post->image() }}" alt="{{ $post->title }}" data-toggle="modal"
                                 data-target="#post{{ $post->id }}">

                            {{-- Modal --}}
                            <div class="modal fade" id="post{{ $post->id }}" tabindex="-1"
                                 aria-labelledby="post{{ $post->id }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Details</a>
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
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
