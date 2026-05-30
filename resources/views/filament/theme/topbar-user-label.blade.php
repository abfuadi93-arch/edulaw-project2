@php($user = filament()->auth()->user())

@if($user)
    <div class="edulaw-topbar-user-label">
        <strong>{{ $user->name }}</strong>
        <small>{{ str($user->role ?? 'user')->headline() }}</small>
    </div>
@endif
