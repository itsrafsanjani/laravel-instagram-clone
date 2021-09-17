@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('posts.store') }}" enctype="multipart/form-data" method="post">
            @csrf

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Add New Post</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group ">
                                        <label for="caption">Post Caption</label>

                                        <input id="caption"
                                               type="text"
                                               class="form-control {{ $errors->has('caption') ? ' is-invalid' : '' }}"
                                               name="caption"
                                               value="{{ old('caption') }}"
                                               placeholder="My beautiful caption..."
                                               autocomplete="caption" autofocus required>

                                        @if ($errors->has('caption'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('caption') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="custom-file">
                                        <label class="control-label" for="image"></label>
                                        <input class="custom-file-input"
                                                id="image"
                                               name="image[]"
                                               accept="image/*"
                                               type="file"
                                               oninput="document.getElementById('pic').src=window.URL.createObjectURL(this.files[0])"
                                               required
                                               multiple>

                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div>
                                        <img id="pic" class="img-thumbnail my-3" alt=""/>
                                    </div>

                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">Add New Post</button>
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
