<div class="card-body {{ request()->routeIs('posts.index') ? ' pt-0' : 'bg-white rounded-top' }}">
    <form>
        <div class="form-group mb-3">
            <input type="hidden" name="post_slug" value="{{ $post->slug }}">
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
        <button class="btn btn-primary btn-sm" id="button-{{ $post->slug }}">Comment</button>
    </form>
</div>

@push('scripts')
    <script>
        $('#button-{{ $post->slug }}').on('click', function (e) {
            e.preventDefault();

            var comment = $('#comment-{{ $post->slug }}').val();
            let _url = '{{ route('comments.store') }}';
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    post_slug: '{{ $post->slug }}',
                    comment: comment,
                    _token: _token
                },
                success: function (data) {
                    comment = data
                    $('#commentList-{{ $post->slug }}').{{ request()->routeIs('posts.index') ? 'append' : 'prepend' }}(`
                            <li class="list-group-item list-group-item-action flex-column align-items-start px-4 py-4">
                            <div class="d-flex w-100 justify-content-between">
                                <div>
                                    <div class="d-flex w-100 align-items-center">
                                        <img src="{{ auth()->user()->profile->profileImage() }}"
                                             alt="Image placeholder" class="avatar avatar-xs mr-2">
                                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                                    </div>
                                </div>
                                <small>${moment(comment.data.created_at).fromNow()}</small>
                            </div>
                            <p class="text-sm mb-0 mt-2">
                            ${comment.data.comment}
                                </p>
                            </li>
                        `);

                    $('#comment-{{ $post->slug }}').val('');

                    $.niceToast.success(comment.message);
                },
                error: function (response) {
                    $.niceToast.error(response.responseJSON.message);
                }
            });
        })


    </script>
@endpush
