@if($user->active_status == true)
    <span class="text-success">●</span>
    <small>{{ __('Online') }}</small>
@else
    <span class="text-gray">●</span>
    <small>{{ __('Offline') }}</small>
@endif
