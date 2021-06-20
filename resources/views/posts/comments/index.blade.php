@if(request()->routeIs('posts.index') && $post->comments_count > 2 )
    <a href="{{ route('posts.show', $post) }}" class="card-blockquote text-sm px-4 py-2">
        See all {{ $post->comments_count }} comments..
    </a>
@endif

<div class="card-body p-0">
    <ul class="list-group list-group-flush" id="commentList-{{ $post->slug }}">
        @forelse($post->comments as $comment)
            <li class="list-group-item list-group-item-action flex-column align-items-start
                                     px-4 py-4 {{ request()->routeIs('posts.index') && $loop->iteration == 2 ? 'rounded-bottom' : '' }}">
                <div class="d-flex w-100 justify-content-between">
                    <div>
                        <div class="d-flex w-100 align-items-center">
                            <img src="{{ $post->user->profile->profileImage() }}"
                                 alt="Image placeholder" class="avatar avatar-xs mr-2">
                            <h5 class="mb-1">{{ $comment->commentator->name }}</h5>
                        </div>
                    </div>
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-sm mb-0 mt-2">
                    {{ Str::limit($comment->comment, 140, ' ...') }}

                </p>
            </li>
            @if(request()->routeIs('posts.index') && $loop->iteration >= 2 )
                @break
            @endif
        @empty
        @endforelse
    </ul>
</div>
