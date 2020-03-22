@extends('layouts.master')
@section('content')

<div class="ui middle aligned center aligned grid">
    <div class="five wide column">
        <div class="ui fluid card">
            <div class="content">
                <h1 class="ui huge header">403 - Unauthorised
                </h1>
                <div class="ui negative message">
                    {{$exception->getMessage()}} If you believe this is a mistake, please contact an admin.
                </div>
                <a href="{{route('auth.logout')}}" class="ui teritary button">Dashboard</a>
                @guest
                    <a href="{{route('auth.login')}}" class="ui teritary primary button">Login with Reddit</a>
                    <p style="margin-top: 10px;">We do not receive your password, nor can we read posts or post on your behalf.</p>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
