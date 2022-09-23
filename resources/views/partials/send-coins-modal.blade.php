<!-- Button trigger modal -->
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#sendCoins">
    <i class="far fa-coins"></i> {{ __('Send coins') }}
</button>

<form action="{{ route('send-coins') }}" method="POST">
    @csrf

    <div class="modal fade" id="sendCoins" tabindex="-1" aria-labelledby="sendCoinsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendCoinsLabel">
                        @lang('Send coins to')
                        <span class="text-primary">{{ $user->username }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="balance">@lang('Current Balance')</label>
                        <input type="number" class="form-control" id="balance" value="{{ auth()->user()->balance }}"
                               disabled>
                    </div>
                    <div class="form-group">
                        <label for="amount">@lang('Amount') <span class="required">*</span></label>
                        <input type="number" class="form-control" name="amount" id="amount" placeholder="@lang('Enter amount')"
                               max="{{ auth()->user()->balance }}" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="new_balance">@lang('New Balance')</label>
                        <input type="number" class="form-control" id="new_balance"
                               value="{{ auth()->user()->balance }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="message">@lang('Message')</label>
                        <textarea class="form-control" name="message" id="message" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button id="sendCoinsButton" type="submit" class="btn btn-primary">@lang('Send')</button>
                </div>
            </div>
        </div>
    </div>
</form>

