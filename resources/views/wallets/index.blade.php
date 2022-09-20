@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">{{ __('My Wallet') }}</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('wallets.create') }}" class="btn btn-primary btn-sm"
                                   data-pjax>
                                    {{ __('Recharge') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <img src="{{ asset('/images/wallet.svg') }}" alt="wallet icon" width="48px"
                                     height="auto">
                            </div>
                            <div class="col-auto">
                                @if(auth()->user()->balance > 0)
                                    <span class="badge badge-lg badge-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge-lg badge-danger">{{ __('Inactive') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="my-4">
                            <span class="h6 surtitle text-muted"> {{ __('Name') }}</span>
                            <div class="h1">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="my-4">
                            <span class="h6 surtitle text-muted"> {{ __('E-mail') }}</span>
                            <div class="h1">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="my-4">
                            <span class="h6 surtitle text-muted"> {{ __('Point') }}</span>
                            <div class="h1"><i class="far fa-coins"></i> {{ auth()->user()->balance }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">{{ __('Orders') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('Transaction ID') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->transaction_id }}
                                    </td>
                                    <td>
                                        {{ $order->amount }}
                                    </td>
                                    <td>
                                        <x-status-badge :status-type="$order->getStatusType()" :status-text="$order->getStatusText()"/>
                                    </td>
                                    <td>
                                        <span class="text-muted" data-toggle="tooltip"
                                              data-original-title="{{ $order->created_at }}">
                                            {{ $order->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        {{ __('No orders found!') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
