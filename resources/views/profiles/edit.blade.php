@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/profile/{{ $user->id }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Edit Profile</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title" class="col-md-4 col-form-label">Title</label>
                                        <input id="title"
                                               type="text"
                                               class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               name="title"
                                               value="{{ old('title') ?? $user->profile->title }}"
                                               autocomplete="title" autofocus>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>

                                        <input id="description"
                                               type="text"
                                               class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                               name="description"
                                               value="{{ old('description') ?? $user->profile->description }}"
                                               autocomplete="description" autofocus>

                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="url">URL</label>

                                        <input id="url"
                                               type="text"
                                               class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                                               name="url"
                                               value="{{ old('url') ?? $user->profile->url }}"
                                               autocomplete="url" autofocus>

                                        @if ($errors->has('url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Profile Image</label>

                                        <input type="file" class="form-control-file" id="image" name="image">

                                        @if ($errors->has('image'))
                                            <strong>{{ $errors->first('image') }}</strong>
                                        @endif
                                    </div>

                                    <div class="form-group pt-4">
                                        <button class="btn btn-primary">Save Profile</button>
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
