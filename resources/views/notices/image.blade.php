@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Image Rules
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Image Ratio <code>1:1</code></li>
                            <li>Profile Picture Resolution <code>400x400</code></li>
                            <li>Post Image Resolution <code>1080x1080</code></li>
                            <li>Image with different resolution and ratio will be converted and add white background if needed.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
