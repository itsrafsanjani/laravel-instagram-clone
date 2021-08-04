@if(request()->routeIs('posts.index') && $post->comments_count > 2 )
    <a href="{{ route('posts.show', $post) }}" class="card-blockquote text-sm px-4 py-2">
        See all {{ $post->comments_count }} comments..
    </a>
@endif

<div class="card-body p-0">
    <ul class="list-group list-group-flush" id="commentList-{{ $post->slug }}">
        @forelse($post->comments as $comment)
            <li class="list-group-item list-group-item-action flex-column align-items-start px-4 py-4
                {{ request()->routeIs('posts.index') ? '' : 'rounded-bottom' }}">
                <div class="d-flex w-100 justify-content-between">
                    <div>
                        <a href="{{ route('profiles.show', $comment->commentator) }}" class="d-flex w-100 align-items-center">
                            <img src="{{ $comment->commentator->profile->profileImage() }}"
                                 alt="Image placeholder" class="avatar avatar-xs mr-2">
                            <h5 class="mb-1">{{ $comment->commentator->name }}</h5>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small data-toggle="tooltip" data-placement="top" title="{{ $post->created_at }}">
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                        @if($comment->user_id == auth()->id())
                            <div class="custom-control custom-checkbox custom-checkbox-success">
                                <form>
                                    <button type="submit" class="commentDeleteButton btn btn-danger btn-sm"
                                            data-comment-id="{{ $comment->id }}" data-toggle="tooltip"
                                            data-placement="top" title="Delete"><i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <p class="text-sm mb-0 mt-2">
                    {{ Str::limit($comment->comment, 140, ' ...') }}
                </p>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
            </li>
        @empty
        @endforelse
    </ul>
</div>
