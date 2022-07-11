@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Short Url') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('short-urls.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="url">
                                    {{ __('Url') }}
                                </label>
                                <input id="url" type="url"
                                          class="form-control  @error('url') is-invalid @enderror"
                                          name="url"
                                          value="{{ old('url') }}"
                                          required>

                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="customKey">
                                    {{ __('Custom Key') }}
                                </label>
                                <input id="customKey" type="text"
                                          class="form-control  @error('custom_key') is-invalid @enderror"
                                          name="custom_key"
                                          value="{{ old('custom_key') }}">

                                @error('custom_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
