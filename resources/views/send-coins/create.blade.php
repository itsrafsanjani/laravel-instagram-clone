@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @lang('Send coins to')
                        <span class="text-primary">{{ $receiver->username }}</span>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('send-coins.store') }}">
                            @csrf

                            <input type="hidden" name="receiver" value="{{ $receiver->id }}">

                            <div class="form-group">
                                <label for="receiver">@lang('Receiver') <span class="required">*</span></label>
                                <input type="text" class="form-control @error('receiver') is-invalid @enderror"
                                       id="receiver" value="{{ $receiver->username }}" disabled>

                                @error('receiver')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="balance">@lang('Current Balance')</label>
                                <input type="number" class="form-control" id="balance"
                                       value="{{ auth()->user()->balance }}"
                                       disabled>
                            </div>

                            <div class="form-group">
                                <label for="amount">@lang('Amount') <span class="required">*</span></label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                       name="amount" id="amount" placeholder="@lang('Enter amount')"
                                       value="{{ old('amount') }}"
                                       max="{{ auth()->user()->balance }}" autocomplete="off" required>

                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="sendCoinsButton">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
