@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <div class="ui clearing">
                <h1 class="ui left floated header">
                    View Mutes
                </h1>
                <a href="{{ route('site.moderation-actions.mutes.create') }}" class="ui right floated primary button">Create Mute</a>
{{--                <a href="#" class="ui right floated button">Import Bans</a>--}}
{{--                <a href="#" class="ui right floated button">Export Bans</a>--}}
            </div>
            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="current">Current</a>
                <a class="item" data-tab="expired">Expired</a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="current">
                <table class="ui celled table">
                    <thead>
                        <th>Reddit username</th>
                        <th>Discord username</th>
                        <th>Muted at</th>
                        <th>Muted until</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($currentMutes as $mute)
                            <tr>
                                <td>{{ $mute->reddit_username }}</td>
                                <td>{{ $mute->discord_username ?? 'N/A' }}</td>
                                <td>{{ $mute->start_at->toDayDateTimeString() }}</td>
                                <td>{{ $mute->end_at->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('site.moderation-actions.mutes.show', $mute) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ui bottom attached tab segment" data-tab="expired">
                <table class="ui celled table">
                    <thead>
                        <th>Reddit username</th>
                        <th>Discord username</th>
                        <th>Muted at</th>
                        <th>Muted until</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($expiredMutes as $mute)
                            <tr>
                                <td>{{ $mute->reddit_username }}</td>
                                <td>{{ $mute->discord_username ?? 'N/A' }}</td>
                                <td>{{ $mute->start_at->toDayDateTimeString() }}</td>
                                <td>{{ $mute->end_at->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('site.moderation-actions.mutes.show', $mute) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.tabular.menu .item').tab();
    </script>
    <script defer>
        $(document).ready( function () {
            $('.table').DataTable();
        } );
    </script>
@endsection
