@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name') }}"
                                           autocomplete="name"
                                           autofocus
                                           required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           autocomplete="email"
                                           required>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="text-muted">
                                        <small>
                                            {{ __('Email verification is turned on, so please use your original email to get the verification link.') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Username') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           name="username"
                                           value="{{ old('username') }}"
                                           autocomplete="username"
                                           required>

                                    <div class="text-muted">
                                        <small>
                                            {{ __('Choose a nice username!') }}
                                            <strong>
                                                <a href="{{ route('notices.username') }}">
                                                    {{ __('Rules!') }}
                                                </a>
                                            </strong>
                                        </small>
                                    </div>

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row d-flex align-items-center">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Gender') }}
                                </label>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input name="gender"
                                               class="form-check-input @error('gender') is-invalid @enderror" id="male"
                                               type="radio"
                                               value="male" {{ old('gender') == 'male' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label" for="male">{{ __('Male') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="gender"
                                               class="form-check-input @error('gender') is-invalid @enderror"
                                               id="female" type="radio"
                                               value="female" {{ old('gender') == 'female' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label" for="female">{{ __('Female') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input name="gender"
                                               class="form-check-input @error('gender') is-invalid @enderror"
                                               id="others" type="radio"
                                               value="others" {{ old('gender') == 'others' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label" for="others">{{ __('Others') }}</label>

                                        @error('gender')
                                        <span class="invalid-feedback ml--3" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Password') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           autocomplete="new-password"
                                           required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm"
                                           type="password"
                                           class="form-control"
                                           name="password_confirmation"
                                           autocomplete="new-password"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
