@extends('layouts.master')
@section('content')
<div class="ui middle aligned center aligned grid">
    <div class="five wide column">
        <div class="ui fluid card">
            <div class="content">
                <h1 class="ui huge header">MHoC Speakership</h1>
                @auth
                    <p>Hi, {{Auth::user()->username}}!</p>
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
                    <p style="margin-top: 10px;">We do not receive your password, nor can we read posts or post on your behalf.</p>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
