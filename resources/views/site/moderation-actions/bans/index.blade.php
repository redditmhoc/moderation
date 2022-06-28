@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <div class="ui clearing">
                <h1 class="ui left floated header">
                    View Bans
                </h1>
                <a href="{{ route('site.moderation-actions.bans.create') }}" class="ui right floated primary button">Create Ban</a>
{{--                <a href="#" class="ui right floated button">Import Bans</a>--}}
{{--                <a href="#" class="ui right floated button">Export Bans</a>--}}
            </div>
            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="current">Current</a>
                <a class="item" data-tab="permanent">Permanent</a>
                <a class="item" data-tab="expired">Expired</a>
                <a class="item" data-tab="overturned">Overturned</a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="current">
                <table class="ui celled table">
                    <thead>
                        <th>Reddit username</th>
                        <th>Discord username</th>
                        <th>Banned at</th>
                        <th>Banned until</th>
                        <th>Platforms</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($currentBans as $ban)
                            <tr>
                                <td>{{ $ban->reddit_username }}</td>
                                <td>{{ $ban->discord_username ?? 'N/A' }}</td>
                                <td>{{ $ban->start_at->toDayDateTimeString() }}</td>
                                <td>{{ $ban->end_at->toDayDateTimeString() }}</td>
                                <td>{{ ucwords(strtolower($ban->platforms)) }}</td>
                                <td>
                                    <a href="{{ route('site.moderation-actions.bans.show', $ban) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ui bottom attached tab segment" data-tab="permanent">
                <table class="ui celled table">
                    <thead>
                    <th>Reddit username</th>
                    <th>Discord username</th>
                    <th>Banned at</th>
                    <th>Platforms</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                    @foreach ($permanentBans as $ban)
                        <tr>
                            <td>{{ $ban->reddit_username }}</td>
                            <td>{{ $ban->discord_username ?? 'N/A' }}</td>
                            <td>{{ $ban->start_at->toDayDateTimeString() }}</td>
                            <td>{{ ucwords(strtolower($ban->platforms)) }}</td>
                            <td>
                                <a href="{{ route('site.moderation-actions.bans.show', $ban) }}">View</a>
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
                    <th>Banned from</th>
                    <th>Banned to</th>
                    <th>Platforms</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                    @foreach ($expiredBans as $ban)
                        <tr>
                            <td>{{ $ban->reddit_username }}</td>
                            <td>{{ $ban->discord_username ?? 'N/A' }}</td>
                            <td>{{ $ban->start_at->toDayDateTimeString() }}</td>
                            <td>{{ $ban->end_at->toDayDateTimeString() }}</td>
                            <td>{{ ucwords(strtolower($ban->platforms)) }}</td>
                            <td>
                                <a href="{{ route('site.moderation-actions.bans.show', $ban) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ui bottom attached tab segment" data-tab="overturned">
                <table class="ui celled table">
                    <thead>
                    <th>Reddit username</th>
                    <th>Discord username</th>
                    <th>Overturned at</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                    @foreach ($overturnedBans as $ban)
                        <tr>
                            <td>{{ $ban->reddit_username }}</td>
                            <td>{{ $ban->discord_username ?? 'N/A' }}</td>
                            <td>{{ $ban->overturned_at->toDayDateTimeString() }}</td>
                            <td>
                                <a href="{{ route('site.moderation-actions.bans.show', $ban) }}">View</a>
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
