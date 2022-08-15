@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">{{ __('Short Urls') }}</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('short-urls.create') }}" class="btn btn-primary btn-sm"
                                   data-pjax>
                                    {{ __('Create a new short url') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Short Url') }}</th>
                                    <th>{{ __('Destination Url') }}</th>
                                    <th>{{ __('Created at') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($urls as $url)
                                    <tr>
                                        <td>
                                            <a href="{{ $url->default_short_url }}" class="font-weight-bold">{{ $url->default_short_url }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ $url->destination_url }}" class="font-weight-bold">{{ $url->destination_url }}</a>
                                        </td>
                                        <td>
                                            <span class="text-muted" data-toggle="tooltip" data-original-title="{{ $url->created_at }}">
                                                {{ $url->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="table-actions d-flex">
                                            <a href="#!" class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-original-title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('short-urls.destroy', $url) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                </div>
            </div>
        </div>
    </div>
@endsection
