@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Notifications</h3>
                    </div>

                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($notifications as $notification)
                                <a href="#" class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <img alt="Image placeholder" src="{{ \App\Models\User::findOrFail($notification->data['following_id'])->avatar }}"
                                             class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">{{ \App\Models\User::findOrFail($notification->data['following_id'])->name }}</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                <small>2 hrs ago</small>
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                                    </div>
                                </div>
                            </a>
                            @empty
                                <div href="#" class="list-group-item list-group-item-action text-center">
                                    No notifications!
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <a href="#" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
                </div>
            </div>
        </div>
    </div>
@endsection
