<div id="likeButton-{{ $post->slug }}">
    <span id="likeCount-{{ $post->slug }}">
        {{ $post->likes->count() }}
    </span>
    <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger likeBtn' : 'far fa-heart text-danger likeBtn'}}"
       data-toggle="tooltip" title="Like" id="likeIcon-{{ $post->slug }}"></i>
</div>

@push('scripts')
<script>
    $('#likeButton-{{ $post->slug }}').on('click', function (e) {
        e.preventDefault();

        let _url = '{{ url('likes') }}' + '/' + '{{ $post->slug }}';
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                _token: _token
            },
            success: function (data) {
                let likes = data
                if (likes.data.status === 'liked') {
                    $('#likeIcon-{{ $post->slug }}').addClass('fas').removeClass('far')

                } else {
                    $('#likeIcon-{{ $post->slug }}').addClass('far').removeClass('fas')
                }
                $('#likeCount-{{ $post->slug }}').text(likes.data.like_count)

                $.niceToast.success(likes.message);
            },
            error: function (response) {
                $.niceToast.error(response.responseJSON.message);
            }
        });
    })
</script>
@endpush
