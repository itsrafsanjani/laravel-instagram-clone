@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">{{ __('Notifications') }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($notifications as $notification)
                                {{ $notification->markAsRead() }}
                                <a href="{{ url('/users/' . $notification->data['follower']['username']) }}"
                                   class="list-group-item list-group-item-action rounded {{ $notification->read_at ?? 'unread-notification' }}">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <img alt="{{ $notification->data['follower']['name'] }}"
                                                 src="{{ $notification->data['follower']['avatar'] ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($notification->data['follower']['email'] ?? ''))) }}"
                                                 class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">
                                                        {{ $notification->data['follower']['name'] }}
                                                    </h4>
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">{{ __('Started following you.') }}</p>

                                            <div class="text-muted d-block d-md-none"
                                                 data-toggle="tooltip"
                                                 data-placement="top"
                                                 title="{{ $notification->created_at }}">
                                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="col-auto d-none d-md-block text-muted"
                                             data-toggle="tooltip"
                                             data-placement="top"
                                             title="{{ $notification->created_at }}">
                                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div href="#" class="list-group-item list-group-item-action text-center">
                                    {{ __('No notifications!') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
