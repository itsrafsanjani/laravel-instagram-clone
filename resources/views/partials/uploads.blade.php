<div class="row">
    @forelse($medias as $media)
        <div class="col-md-4 fileSelector">
            <img
                src="{{ $media->url }}"
                alt="{{ $media->file_name }}"
                data-id="{{ $media->id }}"
                @class([
                    'img-thumbnail',
                    'bg-danger' => in_array($media->id, $selected),
                ])
            >
        </div>
    @empty
        <h3>No files found.</h3>
    @endforelse
</div>
