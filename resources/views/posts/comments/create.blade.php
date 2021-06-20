<div class="card-body px-4 py-0">
    <form>
        @csrf
        <div class="form-group">
            <label class="form-control-label" for="comment-{{ $post->slug }}">
                Comment
            </label>
            <textarea class="form-control"
                      id="comment-{{ $post->slug }}"
                      rows="3"
                      resize="none"
                      placeholder="Write your comment here.."></textarea>
        </div>
    </form>
</div>
