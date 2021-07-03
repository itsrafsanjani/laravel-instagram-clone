<div class="card-body {{ request()->routeIs('posts.index') ? ' pt-0' : 'bg-white rounded-top' }}">
    <form>
        <div class="form-group mb-3">
            <label class="form-control-label" for="comment-{{ $post->slug }}">
                Comment
            </label>
            <textarea class="form-control"
                      id="comment-{{ $post->slug }}"
                      name="comment"
                      rows="3"
                      resize="none"
                      placeholder="Write your comment here..">{{ old('comment') }}</textarea>
        </div>
        <button class="btn btn-primary btn-sm commentButton"
                data-post-slug="{{ $post->slug }}"
                data-request-is="{{ request()->routeIs('posts.index') }}">Comment</button>
    </form>
</div>
