@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Recharge Wallet') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('wallets.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="amount">
                                    {{ __('Amount') }}
                                    <span class="required">*</span>
                                    <small class="text-muted">({{ __('1 BDT = 1 Coin') }})</small>
                                </label>
                                <input id="amount" type="number"
                                          class="form-control  @error('amount') is-invalid @enderror"
                                          name="amount"
                                          value="{{ old('amount') }}"
                                          required>

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
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
