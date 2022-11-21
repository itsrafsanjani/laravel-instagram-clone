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
                            <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>

                                        <input id="name"
                                               type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name') ?? $user->name }}"
                                               autocomplete="name">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">{{ __('Username') }}</label>

                                        <input id="username"
                                               type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username"
                                               value="{{ old('username') ?? $user->username }}"
                                               autocomplete="username">

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}</label>

                                        <input id="email"
                                               type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') ?? $user->email }}"
                                               autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <div class="text-muted">
                                            <small>
                                                {{ __('You can change your username twice in the interval of 14 days.') }}
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number">{{ __('Phone Number') }}</label>

                                        <input id="phone_number"
                                               type="tel"
                                               class="form-control @error('phone_number') is-invalid @enderror"
                                               name="phone_number"
                                               value="{{ old('phone_number') ?? $user->phone_number }}"
                                               placeholder="+88017********"
                                               autocomplete="phone_number">

                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="website">{{ __('Website') }}</label>

                                        <input id="website"
                                               type="url"
                                               class="form-control @error('website') is-invalid @enderror"
                                               name="website"
                                               value="{{ old('website') ?? $user->website }}"
                                               placeholder="https://example.com"
                                               autocomplete="website">

                                        @error('website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="bio">{{ __('Bio') }}</label>

                                        <textarea id="bio"
                                                  type="text"
                                                  class="form-control @error('bio') is-invalid @enderror"
                                                  name="bio"
                                                  maxlength="150"
                                                  placeholder="{{ __('My awesome bio') }}..."
                                                  autocomplete="bio">{{ old('bio') ?? $user->bio }}</textarea>

                                        @error('bio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="gender">{{ __('Gender') }}</label>

                                        <select id="gender"
                                                class="form-control @error('gender') is-invalid @enderror"
                                                name="gender"
                                                autocomplete="gender">
                                            <option value="male" @selected($user->gender == 'male')>{{ __('Male') }}</option>
                                            <option value="female" @selected($user->gender == 'female')>{{ __('Female') }}</option>
                                            <option value="others" @selected($user->gender == 'others')>{{ __('Others') }}</option>
                                        </select>

                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="avatar">{{ __('Avatar') }}</label>

                                        <input type="file"
                                               class="form-control-file"
                                               id="avatar"
                                               name="avatar"
                                               accept="image/*"
                                               oninput="document.getElementById('avatar-img').src=window.URL.createObjectURL(this.files[0])">

                                        <img src="{{ $user->avatar }}" id="avatar-img" class="img-thumbnail my-3"
                                             alt="{{ $user->name }}"/>

                                        <div class="text-muted">
                                            <small>
                                                {{ __('Choose a square image for best experience!') }} <strong><a
                                                        href="{{ route('notices', 'image') }}">{{ __('Rules!') }}</a></strong>
                                            </small>
                                        </div>

                                        @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group pt-4">
                                        <button class="btn btn-primary">{{ __('Save Profile') }}</button>
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
