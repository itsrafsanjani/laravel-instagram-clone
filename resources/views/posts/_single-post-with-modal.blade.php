<div class="col-md-4 pb-4">
    <div class="owl-carousel">
        @php $images = $post->getMedia('posts') @endphp
        @forelse($images as $image)
            <img title="More {{ $images->count()-1 }} images.."
                 type="button"
                 class="w-100 rounded owl-lazy"
                 src="{{ asset('images/placeholder.jpg') }}"
                 data-toggle="modal"
                 data-target="#post{{ $post->id }}"
                 data-src="{{ $image->getUrl('square') }}" alt="{{ $post->caption }}">
            @break
        @empty

        @endforelse
    </div>

    {{-- Modal --}}
    <div class="modal fade"
         id="post{{ $post->id }}"
         tabindex="-1"
         aria-labelledby="post{{ $post->id }}Label"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="post{{ $post->id }}Label">{{ $post->caption }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="owl-carousel">
                        @php $images = $post->getMedia('posts') @endphp
                        @forelse($images as $image)
                            <img class="w-100 rounded owl-lazy" src="{{ asset('images/placeholder.jpg') }}"
                                 data-src="{{ $image->getUrl('square') }}" alt="{{ $post->caption }}">
                        @empty

                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
