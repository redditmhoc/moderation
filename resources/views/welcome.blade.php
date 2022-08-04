@extends('layouts.main')
@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="five wide column">
            @auth
                <p class="text-mhoc">Hi, {{Auth::user()->username}}!</p>
                @can('access site')
                    <a href="{{ route('site.index') }}" class="ui primary button">Access site</a>
                    <a href="#" class="ui red button">Logout</a>
                @else
                    <div class="ui negative message">
                        You do not have permissions to access this site.
                    </div>
                    <a href="{{ route('auth.logout') }}" class="ui red button">Logout</a>
                @endcan
            @endauth
            @guest
                <a href="{{ route('auth.oauth.reddit.login') }}" class="ui primary button">Login with Reddit</a>
                <p style="margin-top: 10px;">We do not receive your password, nor can we read posts, or post on your behalf.</p>
            @endguest
        </div>
    </div>
@endsection
