@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('users.update', $user) }}" enctype="multipart/form-data" method="post">
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

                                        <input type="file" class="form-control-file" id="image" name="image" oninput="document.getElementById('pic').src=window.URL.createObjectURL(this.files[0])">

                                        <img src="{{ auth()->user()->avatar }}" id="pic" class="img-thumbnail my-3" alt=""/>

                                        <div class="text-muted">
                                            <small>
                                                Choose a square image for best experience! <strong><a href="{{ route('notices.image') }}">Rules!</a></strong>
                                            </small>
                                        </div>

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
