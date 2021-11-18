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
                                    <h5 class="h3 mb-0">{{ __('Profiles') }}</h5>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ route('users.index') }}"
                                       data-pjax
                                       class="btn btn-sm btn-neutral">
                                        {{ __('Reset') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Card search -->
                        <div class="card-header py-0">
                            <!-- Search form -->
                            <form action="{{ route('users.index') }}" method="get">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-lg input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="fas fa-search"></span>
                                            </div>
                                        </div>
                                        <input type="text"
                                            name="q"
                                            class="form-control"
                                            placeholder="{{ __('Search') }}"
                                            value="{{ $query ?? '' }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                @forelse($users as $user)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Avatar -->
                                                <a href="{{ route('users.show', $user) }}"
                                                   data-pjax
                                                   class="avatar rounded-circle">
                                                    <img alt="{{ $user->name }}"
                                                         src="{{ $user->avatar }}">
                                                </a>
                                            </div>
                                            <div class="col ml--2">
                                                <h4 class="mb-0">
                                                    <a href="{{ route('users.show', $user) }}"
                                                       data-pjax>
                                                        {{ $user->username }}
                                                    </a>
                                                </h4>

                                                <p class="text-sm mb-0">
                                                    {{ Str::limit($user->name, 30) }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="col">
                                        <h3 class="text-center text-muted">{{ __('No users to show!') }}</h3>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
