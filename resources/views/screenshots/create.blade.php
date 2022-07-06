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
                                    @if(session('link'))
                                        <a href="{{ session('link') }}" class="btn btn-success btn-block mb-3" target="_blank">
                                            {{ session('link') }}
                                        </a>
                                    @endif

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
                                               value="{{ old('url') }}"
                                        >

                                        @error('url')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="width">{{ __('Width') }}</label>

                                                <input id="width"
                                                       type="number"
                                                       class="form-control @error('width') is-invalid @enderror"
                                                       name="width"
                                                       placeholder="{{ __('Width') }}"
                                                       autocomplete="width"
                                                       autofocus
                                                       required
                                                       value="{{ old('width') ?? '800'}}"
                                                >

                                                @error('width')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="height">{{ __('Height') }}</label>

                                                <input id="height"
                                                       type="number"
                                                       class="form-control @error('height') is-invalid @enderror"
                                                       name="height"
                                                       placeholder="{{ __('Height') }}"
                                                       autocomplete="height"
                                                       autofocus
                                                       required
                                                       value="{{ old('height') ?? '600' }}"
                                                >

                                                @error('height')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
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
