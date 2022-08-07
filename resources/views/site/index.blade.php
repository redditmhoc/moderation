@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div class="container my-10 mx-auto">
        <h1 class="text-3xl text-mhoc">MHoC Moderation</h1>
        <div class="card mt-4 bg-base-100 border-2 w-1/3">
            <div class="card-body">
                <h2 class="card-title">Welcome, {{ Auth::user()->username }}</h2>
                <div class="meta">
                    <i style="color:{{ auth()->user()->roles()->first()->colour_hex }}" class="circle icon"></i> {{ucfirst(auth()->user()->roles()->first()->name)}}
                </div>
                <div class="card-actions justify-end">
                    <a href="{{ route('auth.logout') }}" class="btn btn-error btn-sm">Logout</a>
                </div>
            </div>
        </div>
        <br>
        <div class="ui grid">
            <div class="two-wide-column">
                <h3>Bans</h3>
                @can('create bans')
                    <a href="{{ route('site.moderation-actions.bans.create') }}" class="ui mhoc button">Create Ban</a>
                @endcan
                @can('view moderation actions')
                    <a href="{{ route('site.moderation-actions.bans.index') }}" class="ui button">View Bans</a>
                @endcan
                <h3>Mutes</h3>
                @can('create mutes')
                    <a href="{{ route('site.moderation-actions.mutes.create') }}" class="ui mhoc button">Create Mute</a>
                @endcan
                @can('view moderation actions')
                    <a href="{{ route('site.moderation-actions.mutes.index') }}" class="ui button">View Mutes</a>
                @endcan
                <h3>Notes</h3>
                @can('create notes')
                    <a href="{{ route('site.notes.create') }}" class="ui mhoc button">Create Note</a>
                @endcan
                @can('view moderation actions')
                    <a href="{{ route('site.notes.index') }}" class="ui button">View Notes</a>
                @endcan
                <h3>Information</h3>
                <a onclick="alert('Not implemented yet, ask Quad')" class="ui button">Guidance and Templates</a>
                <a onclick="toggleIssueReportModal()" class="ui button">Report bug/issue</a>
            </div>
        </div>
    </div>
{{--    <div id="issueReportModal" class="ui modal">--}}
{{--        <i class="close icon"></i>--}}
{{--        <div class="content">--}}
{{--            <h3 class="ui header">Send issue report</h3>--}}
{{--            <livewire:create-issue-report/>--}}
{{--        </div>--}}
{{--    </div>--}}
    <script>
        function toggleIssueReportModal() {
            $('#issueReportModal')
                .modal('toggle')
            ;
        }
    </script>
@endsection
