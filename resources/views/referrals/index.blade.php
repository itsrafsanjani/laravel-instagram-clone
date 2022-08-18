@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">{{ __('My Referral ID') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="referral_url">
                                {{ __('Referral Url') }}
                                <span class="required">*</span>
                            </label>
                            <input id="referral_url" type="url"
                                   class="form-control  @error('referral_url') is-invalid @enderror"
                                   name="referral_url"
                                   value="{{ $referralLink }}"
                                   disabled>

                            @error('referral_url')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">{{ __('Referrals') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Created at') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($referrals as $referral)
                                <tr>
                                    <td>
                                        <a href="{{ route('users.show', $referral->referralable->username) }}"
                                           class="font-weight-bold">
                                            {{ $referral->referralable->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $referral->referralable->username) }}"
                                           class="font-weight-bold">
                                            {{ $referral->referralable->username }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $referral->referralable->username) }}"
                                           class="font-weight-bold">
                                            {{ $referral->referralable->name }}
                                        </a>
                                    </td>
                                    <td>
                                            <span class="text-muted" data-toggle="tooltip"
                                                  data-original-title="{{ $referral->created_at }}">
                                                {{ $referral->created_at->diffForHumans() }}
                                            </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        {{ __('No urls found!') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $referrals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
