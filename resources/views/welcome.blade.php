@extends('layouts.main')
@section('content')
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                @if (!auth()->check())
                    <h1 class="text-3xl font-bold">Authentication required</h1>
                    <p class="py-6">Access for Moderators, Quadrumvirate, and Developers only. If you require access, please contact the Quadrumvirate</p>
                    <a href="{{ route('auth.oauth.reddit.login') }}" role="button" class="btn btn-primary btn-wide">Login with Reddit</a>
                @else
                    <h1 class="text-3xl font-bold">Hi {{ Auth::user()->username }}</h1>
                    @can('access site')
                        <a href="{{ route('site.index') }}" role="button" class="btn btn-wide btn-primary mt-6">Access site</a>
                    @elsecan
                        <p class="mt-6">You do not have access to this site. Please contact the Quadrumvirate for access.</p>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
