@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('posts.store') }}" enctype="multipart/form-data" method="post">
            @csrf

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ __('Add New Post') }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group ">
                                        <label for="caption">{{ __('Post Caption') }}</label>

                                        <input id="caption"
                                               type="text"
                                               class="form-control @error('caption') is-invalid @enderror"
                                               name="caption"
                                               value="{{ old('caption') }}"
                                               placeholder="{{ __('My beautiful caption...') }}"
                                               autocomplete="caption" autofocus required>

                                        @error('caption')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="image">{{ __('Images') }}</label>
                                        <input class="form-control @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image[]"
                                               accept="image/*"
                                               type="file"
                                               required
                                               multiple>

                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row" id="preview"></div>

                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">{{ __('Add New Post') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            let preview = $("#preview");
            $('#image').change(function(){
                preview.html('');
                for (let i = 0; i < $(this)[0].files.length; i++) {
                    console.log('file'+ this.files[i])
                    preview.append(`<div class="col-md-6">
                            <img src="${window.URL.createObjectURL(this.files[i])}" class="img-thumbnail my-3" alt="image"/>
                        </div>`);
                }
            });
        });
    </script>
@endpush
