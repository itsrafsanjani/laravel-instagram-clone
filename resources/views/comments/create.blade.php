<div class="card-body px-3 px-md-4 {{ request()->routeIs('posts.index') ? 'pt-0' : 'py-2 bg-white rounded-top' }}">
    <form>
        <div class="form-group mb-3">
            <label class="form-control-label" for="comment-{{ $post->slug }}">
                {{ __('Comments') }}
            </label>
            <div class="d-flex justify-content-end align-items-center">
                <img alt="{{ auth()->user()->name }}"
                     class="avatar avatar-sm rounded-circle mr-md-3 mr-2"
                     src="{{ auth()->user()->avatar }}">
                <textarea class="form-control commentTextarea"
                          id="comment-{{ $post->slug }}"
                          name="comment"
                          placeholder="{{ __('Press enter to submit') }}"
                          rows="1"
                          spellcheck="false"
                          data-post-slug="{{ $post->slug }}"
                >{{ old('comment') }}</textarea>

                <button class="btn btn-primary d-lg-none ml-md-3 ml-1 commentButton"
                        data-post-slug="{{ $post->slug }}"
                        data-request-is="{{ request()->routeIs('posts.index') }}" disabled>
                    <i class="fas fa-angle-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>
