@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.notes.index') }}">◀ View Notes</a><br>
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
            <a href="{{ route('site.notes.edit', $note) }}" class="ui right floated primary basic button"><i class="edit icon"></i>Edit</a>
            <div class="ui clearing" style="margin-top: 2em;">
                <h1 class="ui mhoc header">
                    Note: {{ $note->reddit_username }}
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
                                <a class="header" href="https://reddit.com/u/{{ $note->reddit_username }}">/u/{{ $note->reddit_username }}</a>
                            </div>
                        </div>
                        <div class="item">
                            <i class="discord icon"></i>
                            <div class="content">
                                @if ($note->discord_username)
                                    {{ $note->discord_username }} {{ $note->discord_id ? "($note->discord_id)" : '' }}
                                @else
                                    No Discord information provided.
                                @endif
                            </div>
                        </div>
                        @if ($note->aliases)
                            <div class="item">
                                <i class="smile outline icon"></i>
                                <div class="content">
                                    {{ $note->aliases }}
                                </div>
                            </div>
                        @endif
                    </div>
            </div>
            <div class="ui dividing header">Content</div>
            <div class="ui segment">
                {{ $note->content ?? 'Not provided.' }}
            </div>
            <div class="ui dividing header">Attachments</div>
            <div class="ui segment">
                <div class="ui three column internally celled grid">
                    @foreach ($note->imageAttachments as $attachment)
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
                    <a href="{{ route('site.image-attachments.create', ['attachable_type' => 'Note', 'attachable_id' => $note->id]) }}" class="ui fluid primary button" style="margin-top:1em;">Add Attachment</a>
                </div>
            </div>

            @can('delete', $note)
                <button onclick="openDeleteModal()" class="ui right floated red basic button"><i class="trash icon"></i> Delete note</button>
            @endcan
        </div>
    </div>
    @can('delete', $note)
        <div id="deleteModal" class="ui basic modal">
            <div class="header">Delete this note</div>
            <div class="content">
                Are you sure?
            </div>
            <div class="actions">
                <div class="ui basic cancel inverted button">
                    Cancel
                </div>
                <form action="{{ route('site.notes.delete', $note) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="ui red button">
                        Delete
                    </butto>
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
