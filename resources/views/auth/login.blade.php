@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <div class="form-group row">
                                <label for="login" class="col-sm-4 col-form-label text-md-right">
                                    {{ __('Username or Email') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="login" type="text"
                                        class="form-control {{ $errors->has('username') || $errors->has('email') ? 'is-invalid' : '' }}"
                                        name="login" value="{{ old('username') ?: old('email') }}" autofocus required>

                                    @if ($errors->has('username') || $errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Password') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control  @error('password') is-invalid @enderror" name="password"
                                        autocomplete="current-password" required>

                                    @error('password')
                                        )
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }} checked>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        @env('local')
                        <div class="mx-auto mt-5 text-center">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <td>Admin Account</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="autoFillAdmin()">
                                                {{ __('Login as Admin') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>User Account</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="autoFillUser()">
                                                {{ __('Login as User') }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endenv
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
