<div class="likeButton"
     data-post-slug="{{ $post->slug }}">
    <span id="likeCount-{{ $post->slug }}">
        {{ $post->likers_count }}
    </span>
    <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger likeBtn' : 'far fa-heart text-danger likeBtn'}}"
       data-toggle="tooltip"
       title="{{ __('Like') }}"
       id="likeIcon-{{ $post->slug }}"></i>
</div>
