<div class="card-body {{ request()->routeIs('posts.index') ? 'pt-0' : 'bg-white rounded-top' }}">
    <form>
        <div class="form-group mb-3">
            <label class="form-control-label" for="comment-{{ $post->slug }}">
                {{ __('Comments') }}
            </label>

            <div class="media align-items-center">
                <img alt="{{ auth()->user()->name }}"
                     class="avatar avatar-sm rounded-circle mr-4"
                     src="{{ auth()->user()->avatar }}">
                <div class="media-body">
                    <form>
                        <textarea class="form-control commentTextarea"
                                  id="comment-{{ $post->slug }}"
                                  name="comment"
                                  placeholder="{{ __('Write your comment') }}"
                                  rows="1"
                                  spellcheck="false"
                                  data-post-slug="{{ $post->slug }}"
                        >{{ old('comment') }}</textarea>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>
