@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <div class="ui clearing">
                <h1 class="ui left floated header">
                    View Notes
                </h1>
                <a href="{{ route('site.notes.create') }}" class="ui right floated primary button">Create Note</a>
            </div>
            <table class="ui celled table">
                <thead>
                    <th>Reddit username</th>
                    <th>Discord username</th>
                    <th>Created by</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{{ $note->reddit_username }}</td>
                            <td>{{ $note->discord_username ?? 'N/A' }}</td>
                            <td>{{ $note->responsibleUser?->username }}</td>
                            <td>
                                <a href="{{ route('site.notes.show', $note) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
