@extends('layouts.app')

@section('content')
    <div class="infinite-scroll">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0">Profiles</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                @forelse($profiles as $profile)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Avatar -->
                                                <a href="{{ route('profiles.show', $profile->user) }}"
                                                   class="avatar rounded-circle">
                                                    <img alt="Image placeholder"
                                                         src="{{ $avatar }}">
                                                </a>
                                            </div>
                                            <div class="col ml--2">
                                                <h4 class="mb-0">
                                                    <a href="{{ route('profiles.show', $profile->user) }}">{{ $profile->username }}</a>
                                                </h4>
                                                <span class="text-success">●</span>
                                                <small>Online</small>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('profiles.show', $profile->user) }}"
                                                   class="btn btn-sm btn-primary">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="col">
                                        <h3 class="text-center text-muted">No users to show!</h3>
                                    </div>
                                @endforelse
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
    </div>

@endsection
