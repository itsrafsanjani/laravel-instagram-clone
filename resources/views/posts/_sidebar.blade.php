<div class="col-md-4 d-md-block order-2">
    <div class="card sticky-top laragram-sidebar">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mr-2">
                        <a href="{{ route('users.show', auth()->user()) }}">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="avatar rounded-circle"
                                 alt="{{ auth()->user()->username }}">
                        </a>
                    </div>
                    <div>
                        <div class="font-weight-bold">
                            <a href="{{ route('users.show', auth()->user()) }}">
                                <span class="text-dark">{{ auth()->user()->username }}</span>
                            </a>
                        </div>
                        <div class="text-muted">
                            <span title="{{ auth()->user()->created_at }}">
                                Joined: {{ auth()->user()->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between px-4 py-2">
            <div class="text-muted text-sm">
                {{ __('Suggestions For You') }}
            </div>
            <div class="text-muted text-sm">
                <a href="{{ route('users.index') }}">{{ __('See All') }}</a>
            </div>
        </div>

        <!-- Card body -->
        <div class="card-body overflow-auto">
            <!-- List group -->
            <ul class="list-group list-group-flush list my--3">
                @forelse($suggestedUsers as $user)
                    <li class="list-group-item px-0 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto d-flex align-items-center">
                                <!-- Avatar -->
                                <a href="{{ route('users.show', $user) }}"
                                   class="avatar avatar-sm rounded-circle">
                                    <img alt="{{ $user->name }}"
                                         src="{{ $user->avatar }}">
                                </a>
                            </div>
                            <div class="col ml--2">
                                <h4 class="mb-0 text-sm">
                                    <a href="{{ route('users.show', $user) }}">
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
</div>
