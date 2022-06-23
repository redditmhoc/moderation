@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.moderation-actions.bans.index') }}">◀ View Bans</a><br>
            <div class="ui clearing" style="margin-top: 2em;">
                <h1 class="ui header">
                    Ban: {{ $ban->reddit_username }}
                    <div class="sub header">
                        @if ($ban->permanent)
                            <i class="red calendar times icon"></i> <span class="ui red text">Permanent ban</span>, issued {{ $ban->start_at->toFormattedDateString() }}
                        @elseif ($ban->is_current)
                            <i class="blue history icon"></i> <span class="ui blue text">{{ $ban->days_remaining }} days remaining</span>, ending {{ $ban->end_at->toFormattedDateString() }} {{ $ban->end_at->toTimeString('minute') }}
                        @endif
                    </div>
                </h1>
                <a href="{{ route('site.moderation-actions.bans.edit', $ban) }}" class="ui right floated primary basic button"><i class="edit icon"></i>Edit</a>
            </div>

            <h3 class="ui dividing header">
                User information
            </h3>
            <div class="ui segment">
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
            <h3 class="ui dividing header">Platform</h3>
            <div class="ui segment">
                <div class="ui small header">Reddit or Discord</div>
                {{ ucfirst(strtolower($ban->platforms)) }}
            </div>
            <div class="ui dividing header">Moderator</div>
            <div class="ui segment">
                <div class="ui list">
                    <div class="item">
                        <i class="user icon"></i>
                        <div class="content">
                            <i style="color:{{$ban->responsibleUser->roles()->first()->colour_hex}}" class="circle icon"></i> {{ $ban->responsibleUser->username }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui dividing header">Dates</div>
            <div class="ui segment">
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
            <div class="ui dividing header">Reason</div>
            <div class="ui segment">
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
            <div class="ui dividing header">Attachments</div>
            <div class="ui segment">
                <div class="ui three column internally celled grid">
                    @foreach ($ban->imageAttachments as $attachment)
                        <div class="column">
                            <div style="margin-bottom: 10px;">
                                @if ($attachment->user)
                                    Uploaded by <i style="color:{{$attachment->user->roles()->first()->colour_hex}}" class="circle icon"></i> {{ $attachment->user->username }}:&nbsp;
                                @endif
                                {{ $attachment->caption }}
                            </div>
                            <a href="{{ $attachment->url }}" class="ui medium bordered image">
                                <img src="{{ $attachment->url }}" alt="{{ $attachment->caption }}">
                            </a>
                            <form action="{{ route('site.image-attachments.destroy', $attachment) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="ui small tertiary button">Remove attachment</button>
                            </form>
                        </div>
                    @endforeach
                    <a href="{{ route('site.image-attachments.create', ['attachable_type' => 'ModerationActions\\Ban', 'attachable_id' => $ban->id]) }}" class="ui fluid primary button" style="margin-top:1em;">Add Attachment</a>
                </div>
            </div>
        </div>
    </div>
@endsection
