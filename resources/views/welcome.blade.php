@extends('layouts.master')
@section('content')
<h1 class="ui huge header">MHoC Moderation
    <div class="sub header">
        This site is used to record MHoC Moderation actions.
    </div>
</h1>
@auth
    <p>Hi, {{Auth::user()->username}}! You are a member of the @foreach(Auth::user()->getRoleNames() as $r) <b>{{$r}}</b> @endforeach group.</p>
    @can('access')
    <a href="{{route('dash')}}" class="ui primary button">Access</a>
    <a href="{{route('auth.logout')}}" class="ui red button">Sign-out</a>
    @else
    <div class="ui negative message">
        You are not registered as a member of Speakership. If this is a mistake, please contact the Quadrumvirate.
    </div>
    <a href="{{route('auth.logout')}}" class="ui red button">Sign-out</a>
    @endcan
@endauth
@guest
    <a href="{{route('auth.login')}}" class="ui primary button">Login with Reddit</a>
@endguest
@endsection
