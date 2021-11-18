<li id="comment-{{ $comment->id }}"
    class="list-group-item list-group-item-action flex-column align-items-start px-4 py-4">
    <div class="d-flex w-100 justify-content-between">
        <div>
            <a href="{{ route('users.show', $comment->commentator) }}"
               data-pjax
               class="d-flex w-100 align-items-center">
                <img src="{{ $comment->commentator->avatar }}"
                     alt="{{ $comment->commentator->name }}" class="avatar avatar-xs mr-2">
                <h5 class="mb-1">{{ $comment->commentator->name }}</h5>
            </a>
        </div>
        <div class="d-flex justify-content-between">
            <small data-toggle="tooltip" data-placement="top" title="{{ $post->created_at }}">
                {{ $comment->created_at->diffForHumans() }}
            </small>
            @if($comment->user_id == auth()->id())
                <div class="custom-control custom-checkbox custom-checkbox-success d-none d-md-block">
                    <button class="commentDeleteButton btn btn-danger btn-sm"
                            data-comment-id="{{ $comment->id }}" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <p class="text-sm text-break mb-0 mt-2">
        {{ request()->routeIs('posts.index') ? Str::limit($comment->comment, 140) : $comment->comment }}
    </p>
    <div class="d-flex d-md-none pt-2">
        <small data-toggle="tooltip" data-placement="top" title="{{ $post->created_at }}">
            {{ $comment->created_at->diffForHumans() }}
        </small>
        @if($comment->user_id == auth()->id())
            <small class="commentDeleteButton pl-3" data-comment-id="{{ $comment->id }}" title="Delete">
                <b>Delete</b>
            </small>
        @endif
    </div>
    <input type="hidden" name="post_id" value="{{ $post->id }}">
</li>
