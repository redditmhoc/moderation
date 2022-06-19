@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.moderation-actions.bans.index') }}">◀ View Bans</a><br>
            <h1 class="ui header">Ban: {{ $ban->reddit_username }} ({{ $ban->start_at->toDayDateTimeString() }})</h1>
            @if ($ban->permanent)
                <div class="ui negative message">
                    <div class="header">This is a permanent ban.</div>
                </div>
            @endif
            {{--@if ($errors->overturnBan->any())
                <div class="ui error message">
                    <div class="header">
                        Error overturning ban
                    </div>
                    <div class="ui bulleted list">
                        @foreach ($errors->overturnBan->all() as $e)
                            <div class="item">
                                {{$e}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif--}}
            <br>
            <div class="ui stackable three column grid">
                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">User</div>
                            <div class="ui list">
                                <div class="item">
                                    <i class="reddit icon"></i>
                                    <div class="content">
                                        <a class="header" href="https://reddit.com/u/{{ $ban->reddit_username }}">/u/{{ $ban->reddit_username }}</a>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="discord icon"></i>
                                    <div class="content">
                                        @if ($ban->discord_username)
                                            {{ $ban->discord_username }} {{ $ban->discord_id ? "($ban->discord_id)" : '' }}
                                        @else
                                            No Discord information provided.
                                        @endif
                                    </div>
                                </div>
                                @if ($ban->aliases)
                                    <div class="item">
                                        <i class="smile outline icon"></i>
                                        <div class="content">
                                            {{ $ban->aliases }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">Reddit or Discord</div>
                            {{ ucfirst(strtolower($ban->platforms)) }}
                        </div>
                    </div>
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">Issued by</div>
                            <div class="ui list">
                                <div class="item">
                                    <i class="user icon"></i>
                                    <div class="content">
                                        <i style="color:{{$ban->responsibleUser->roles()->first()->colour_hex}}" class="circle icon"></i> {{ $ban->responsibleUser->username }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header" style="margin-bottom: 10px;">Actions</div>
                            <div class="ui fluid vertical buttons">
                                <a href="#" class="ui button">Edit Ban</a>
                                <a href="#" class="ui button">Export</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">Dates</div>
                            <div class="ui list">
                                <div class="item">
                                    <i class="calendar icon"></i>
                                    <div class="content">
                                        <div class="header">Started at</div>
                                        {{ $ban->start_at->toDayDateTimeString() }} GMT
                                    </div>
                                </div>
                                @if($ban->end_at)
                                    <div class="item">
                                        <i class="calendar icon"></i>
                                        <div class="content">
                                            <div class="header">Ends at</div>
                                            {{ $ban->end_at->toDayDateTimeString() }} GMT
                                        </div>
                                    </div>
                                    <div class="item">
                                        <i class="calendar icon"></i>
                                        <div class="content">
                                            <div class="header">Total duration</div>
                                            {{ $ban->duration_in_days }} days
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">Reasoning and Evidence</div>
                            <div class="ui list">
                                <div class="item">
                                    <div class="content">
                                        <div class="header">Summary</div>
                                        {{ $ban->summary ?? 'Not provided.' }}
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content">
                                        <div class="header">Comments</div>
                                        {{ $ban->comments ?? 'Not provided.' }}
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="content">
                                        <div class="header">Evidence URL</div>
                                        @if ($ban->evidence)
                                            <a href=" {{$ban->evidence }}">{{ $ban->evidence }}</a>
                                        @else
                                            Not provided.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui fluid card">
                        <div class="content">
                            <div class="header">Attachments</div>
                            <div class="ui list">
                                @foreach ($ban->imageAttachments as $attachment)
                                    <div class="item">
                                        <div class="header" style="margin-bottom: 10px;">
                                            @if ($attachment->user)
                                                Uploaded by <i style="color:{{$attachment->user->roles()->first()->colour_hex}}" class="circle icon"></i> {{ $attachment->user->username }}:&nbsp;
                                            @endif
                                            {{ $attachment->caption }}
                                        </div>
                                        <a href="{{ $attachment->url }}" class="ui medium bordered image">
                                            <img src="{{ $attachment->url }}" alt="{{ $attachment->caption }}">
                                        </a>
                                    </div>
                                    <div class="ui divider"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
