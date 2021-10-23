@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Purchase Code Verification') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('purchase.purchase_code') }}">
                            @csrf

                            <div class="form-group">
                                <label for="purchaseCode">
                                    {{ __('Purchase Code') }}
                                </label>
                                <textarea id="purchaseCode" type="password"
                                          class="form-control  @error('purchase_code') is-invalid @enderror"
                                          name="purchase_code"
                                          required></textarea>

                                @error('purchase_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @if(session('message'))
                                    <span class="text-sm text-center text-danger">{{ session('message') }}</span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Check') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
