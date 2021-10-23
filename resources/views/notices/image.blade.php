@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        {{ __('Image Rules') }}
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>{{ __('Image Ratio') }} <code>{{ __('1:1') }}</code></li>
                            <li>{{ __('Profile Picture Resolution') }} <code>{{ __('400x400') }}</code></li>
                            <li>{{ __('Post Image Resolution') }} <code>{{ __('1080x1080') }}</code></li>
                            <li>{{ __('Image with different resolution and ratio will be converted and add white background if needed.') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
