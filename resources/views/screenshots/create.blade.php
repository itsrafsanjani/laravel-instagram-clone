@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('screenshots.store') }}" method="post">
            @csrf

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ __('Generate a new Screenshot') }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group ">
                                        <label for="url">{{ __('Url') }}</label>

                                        <input id="url"
                                                  type="url"
                                                  class="form-control @error('url') is-invalid @enderror"
                                                  name="url"
                                                  placeholder="{{ __('https://10minuteschool.com') }}"
                                                  autocomplete="url"
                                                  autofocus
                                                  required
                                        >{{ old('url') }}</input>

                                        @error('url')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">{{ __('Generate Screenshot') }}</button>
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
