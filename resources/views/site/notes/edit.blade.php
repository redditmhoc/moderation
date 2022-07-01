@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.notes.show', $note) }}">◀ Back</a><br>
            <h1 class="ui header">Edit Mute of {{ $note->reddit_username }}</h1>
            <form action="{{ route('site.notes.update', $note) }}" method="post" class="ui form">
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
                {{ csrf_field() }}
                <h3 class="ui dividing header">
                    Discord
                </h3>
                <div class="ui segment">
                    <div class="field">
                        <label for="discord_username">Discord username (including discriminator)</label>
                        <input type="text" name="discord_username" placeholder="meeyawk#1234" id="discord_username" value="{{ old('discord_username') ?? $note->discord_username }}">
                    </div>
                    <div class="field">
                        <label for="discord_id">Discord snowflake ID <a target="_blank" href="https://support.discord.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-">(how?)</a></label>
                        <input type="text" name="discord_id" placeholder="412754716884336650" id="discord_id" value="{{ old('discord_id') ?? $note->discord_id }}">
                    </div>
                </div>
                <div class="ui dividing header">Moderator responsible</div>
                <div class="ui segment">
                    <div class="required field">
                        <label for="responsible_user_id">Select one</label>
                        <div class="ui selection fluid dropdown">
                            <input type="hidden" value="{{ old('responsible_user_id') ?? $note->responsible_user_id }}" name="responsible_user_id">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select one</div>
                            <div class="menu">
                                @foreach ($moderators as $moderator)
                                    <div class="item" data-value="{{ $moderator->id }}">
                                        <i class="circle icon" style="color:{{ $moderator->roles->first()->colour_hex }}"></i> {{ $moderator->username }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui dividing header">Content</div>
                <div class="ui segment">
                    <textarea id="content" name="content">{{ old('content') ?? $note->content }}</textarea>
                </div>
                <button type="submit" class="ui primary button">Edit Note</button>
            </form>
        </div>
    </div>
    <script>
        $('.selection.dropdown')
            .dropdown()
        ;

        $('.ui.checkbox')
            .checkbox()
        ;
    </script>
@endsection
