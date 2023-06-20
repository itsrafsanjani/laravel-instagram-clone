<div class="row">
    @forelse($medias as $media)
        <div class="col-md-4">
            <img src="{{ $media->url }}" alt="{{ $media->file_name }}" class="img-thumbnail">
        </div>
    @empty
        <h3>No files found.</h3>
    @endforelse
</div>
