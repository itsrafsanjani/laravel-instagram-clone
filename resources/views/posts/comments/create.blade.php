<div class="card-body pt-0">
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
                    $('#commentList-{{ $post->slug }}').append(`
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

                    $.notify({
                        // options
                        icon: 'fa fa-bell',
                        title: comment.type,
                        message: comment.message
                    }, {
                        // settings
                        type: comment.type,
                        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-dismissible alert-{0} alert-notify" ' +
                            'role="alert"><span class="alert-icon" data-notify="icon"></span> ' +
                            '<div class="alert-text"</div> ' +
                            '<span class="alert-title" data-notify="title">{1}</span> ' +
                            '<span data-notify="message">{2}</span></div>' +
                            '<button type="button" class="close" data-notify="dismiss" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button></div>'
                    });

                },
                error: function (response) {
                    $('#comment-{{ $post->slug }}').append(`<div class="alert alert-danger">
                    ${response}</div>
                    `);
                }
            });
        })


    </script>
@endpush
