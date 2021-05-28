@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">404 Page Not Found</h3>
                    </div>
                    <div class="card-body py-5">
                        <h3 class="card-title mb-3">Message</h3>
                        <p class="card-text mb-4">
                            We couldn't find anything that matches to your request. Please check if this is a valid
                            request or go to our home.
                        </p>
                        <div class="text-center">
                            <a href="/" class="btn btn-primary"><i class="fas fa-home"></i> Go back to home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
