@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.moderation-actions.mutes.index') }}">◀ View Mutes</a><br>
            @if ($errors->any())
                <div class="ui negative message">
                    <div class="header">
                        There were some errors with your submission
                    </div>
                    <div class="ui bulleted list">
                        @foreach ($errors->all() as $e)
                            <div class="item">
                                {{ $e }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <a href="{{ route('site.moderation-actions.mutes.edit', $mute) }}" class="ui right floated primary basic button"><i class="edit icon"></i>Edit</a>
            <div class="ui clearing" style="margin-top: 2em;">
                <h1 class="ui mhoc header">
                    Mute: {{ $mute->reddit_username }}
                    <div class="sub header">
                        @if ($mute->is_current)
                            <i class="blue history icon"></i> <span class="ui blue text">{{ $mute->hours_remaining }} hours remaining</span>, ending {{ $mute->end_at->toFormattedDateString() }} {{ $mute->end_at->toTimeString('minute') }}
                        @endif
                    </div>
                </h1>
            </div>
            <h3 class="ui dividing header">
                User information
            </h3>
            <div class="ui segment">
                <div class="ui list">
                        <div class="item">
                            <i class="reddit icon"></i>
                            <div class="content">
                                <a class="header" href="https://reddit.com/u/{{ $mute->reddit_username }}">/u/{{ $mute->reddit_username }}</a>
                            </div>
                        </div>
                        <div class="item">
                            <i class="discord icon"></i>
                            <div class="content">
                                @if ($mute->discord_username)
                                    {{ $mute->discord_username }} {{ $mute->discord_id ? "($mute->discord_id)" : '' }}
                                @else
                                    No Discord information provided.
                                @endif
                            </div>
                        </div>
                        @if ($mute->aliases)
                            <div class="item">
                                <i class="smile outline icon"></i>
                                <div class="content">
                                    {{ $mute->aliases }}
                                </div>
                            </div>
                        @endif
                    </div>
            </div>
            <h3 class="ui dividing header">Platform</h3>
            <div class="ui segment">
                <div class="ui small header">Reddit or Discord</div>
                {{ ucfirst(strtolower($mute->platforms)) }}
            </div>
            <div class="ui dividing header">Moderator</div>
            <div class="ui segment">
                <div class="ui list">
                    <div class="item">
                        <i class="user icon"></i>
                        <div class="content">
                            <i style="color:{{$mute->responsibleUser?->roles()->first()->colour_hex}}" class="circle icon"></i> {{ $mute->responsibleUser?->username }}
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
                            <div class="header">{{ $mute->start_at > now() ? 'Starts' : 'Started' }} at</div>
                            {{ $mute->start_at->toDayDateTimeString() }} {{ $mute->start_at->timezoneAbbreviatedName }}
                        </div>
                    </div>
                    @if($mute->end_at)
                        <div class="item">
                            <i class="calendar icon"></i>
                            <div class="content">
                                <div class="header">{{ $mute->end_at > now() ? 'Ends' : 'Ended' }} at</div>
                                {{ $mute->end_at->toDayDateTimeString() }} {{ $mute->end_at->timezoneAbbreviatedName }}
                            </div>
                        </div>
                        <div class="item">
                            <i class="calendar icon"></i>
                            <div class="content">
                                <div class="header">Total duration</div>
                                {{ $mute->duration_in_hours }} hours
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
                            {{ $mute->summary ?? 'Not provided.' }}
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Comments</div>
                            {{ $mute->comments ?? 'Not provided.' }}
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Evidence URL</div>
                            @if ($mute->evidence)
                                <a href=" {{$mute->evidence }}">{{ $mute->evidence }}</a>
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
                    @foreach ($mute->imageAttachments as $attachment)
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
                    <a href="{{ route('site.image-attachments.create', ['attachable_type' => 'ModerationActions\\Mute', 'attachable_id' => $mute->id]) }}" class="ui fluid primary button" style="margin-top:1em;">Add Attachment</a>
                </div>
            </div>

            @can('delete', $mute)
                <button onclick="openDeleteModal()" class="ui right floated red basic button"><i class="trash icon"></i> Delete mute</button>
            @endcan
        </div>
    </div>
    @can('delete', $mute)
        <div id="deleteModal" class="ui basic modal">
            <div class="header">Delete this mute</div>
            <div class="content">
                Are you sure?
            </div>
            <div class="actions">
                <div class="ui basic cancel inverted button">
                    Cancel
                </div>
                <form action="{{ route('site.moderation-actions.mutes.delete', $mute) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="ui red button">
                        Delete
                    </button>
                </form>
             </div>
        </div>
        <script>
            function openDeleteModal() {
                $('#deleteModal')
                    .modal('toggle')
            }
        </script>
    @endcan
@endsection
