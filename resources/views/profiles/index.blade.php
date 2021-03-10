@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Profiles</h5>
                    </div>
                    <!-- Card search -->
                    <div class="card-header py-0">
                        <!-- Search form -->
                        <form>
                            <div class="form-group mb-0">
                                <div class="input-group input-group-lg input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fas fa-search"></span>
                                        </div>
                                    </div>
                                    <input type="search" class="form-control" placeholder="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3">
                            @foreach($profiles as $profile)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar rounded-circle">
                                                <img alt="Image placeholder"
                                                     src="{{ $profile->profileImage() }}"
                                                     style="height: 50px">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="{{ route('profiles.show', $profile->user) }}">{{ $profile->title }}</a>
                                            </h4>
                                            <span class="text-success">●</span>
                                            <small>Online</small>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-sm btn-primary">Follow</button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-3">
                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
