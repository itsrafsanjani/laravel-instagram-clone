<div class="col-md-4 d-md-block order-2">
    <div class="card sticky-top laragram-sidebar">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="mr-2">
                        <a href="{{ route('users.show', auth()->user()) }}">
                            <img src="{{ auth()->user()->avatar }}"
                                 class="avatar rounded-circle" alt="{{ auth()->user()->username }}">
                        </a>
                    </div>
                    <div>
                        <div class="font-weight-bold">
                            <a href="{{ route('users.show', auth()->user()) }}">
                                <span class="text-dark">{{ auth()->user()->username }}</span>
                            </a>
                        </div>
                        <div class="text-muted">
                                        <span
                                            title="{{ auth()->user()->created_at }}">{{ auth()->user()->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
