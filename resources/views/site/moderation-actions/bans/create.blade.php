@extends('layouts.main')
@section('content')
    @include('layouts.navigation-primary')
    <div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
        <div class="eight column wide">
            <a href="{{ route('site.moderation-actions.bans.index') }}">◀ View Bans</a><br>
            <h1 class="ui header">Create Ban</h1>
            <form action="{{ route('site.moderation-actions.bans.store') }}" method="post" class="ui form">
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
                    User information
                </h3>
                <div class="ui segment">
                    <div class="required field">
                        <label for="reddit_username">Reddit username, no /u/</label>
                        <input type="text" id="reddit_username" name="reddit_username" placeholder="meeyawk" value="{{ old('reddit_username') }}">
                    </div>
                    <div class="field">
                        <label for="discord_username">Discord username (including discriminator)</label>
                        <input type="text" name="discord_username" placeholder="meeyawk#1234" id="discord_username" value="{{ old('discord_username') }}">
                    </div>
                    <div class="field">
                        <label for="discord_id">Discord snowflake ID <a target="_blank" href="https://support.discord.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-">(how?)</a></label>
                        <input type="text" name="discord_id" placeholder="412754716884336650" id="discord_id" value="{{ old('discord_id') }}">
                    </div>
                </div>
                <div class="ui dividing header">Moderator responsible</div>
                <div class="ui segment">
                    <div class="required field">
                        <label for="responsible_user_id">Select one</label>
                        <div class="ui selection fluid dropdown">
                            <input type="hidden" value="{{ old('responsible_user_id') ?? auth()->id() }}" name="responsible_user_id">
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
                <div class="ui dividing header">Details</div>
                <div class="ui segment">
                    <div class="two fields">
                        <div class="required field">
                            <label for="start_at">Start date/time</label>
                            <input type="date" name="start_at" value="{{ old('start_at') }}" class="flatpickr" placeholder="Select" id="start_at">
                        </div>
                        <div class="field">
                            <label for="end_at">End date/time <a href="https://www.timeanddate.com/date/dateadd.html" target="_blank">(calculator to add months/days)</a> (leave blank if selecting permanent)</label>
                            <input type="date" name="end_at" value="{{ old('end_at') }}" class="flatpickr" placeholder="Select" id="end_at">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle @if(old('permanent') != null) checked @endif checkbox">
                            <input type="checkbox" name="permanent" @if(old('permanent') != null) checked="" @endif class="hidden">
                            <label>Permanent ban</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox @if(old('user_can_appeal') != null) checked @endif checkbox">
                            <input type="checkbox" name="user_can_appeal" @if(old('user_can_appeal') != null) checked="" @endif class="hidden">
                            <label>User can appeal ban</label>
                        </div>
                    </div>
                    <div class="required field">
                        <label for="platforms">Platform</label>
                        <div class="ui selection fluid dropdown">
                            <input type="hidden" value="{{ old('platforms') }}" name="platforms">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select one</div>
                            <div class="menu">
                                <div class="item" data-value="BOTH">Both</div>
                                <div class="item" data-value="REDDIT">Reddit only</div>
                                <div class="item" data-value="DISCORD">Discord only</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui dividing header">Reason</div>
                <div class="ui segment">
                    <div class="required field">
                        <label for="summary">Summary</label>
                        <input type="text" value="{{ old('summary') }}" name="summary" id="summary" placeholder="Doesn't like coffee">
                    </div>
                    <div class="field">
                        <label for="comments">Commentary</label>
                        <textarea id="comments" value="{{ old('comments') }}" name="comments" placeholder="Type any extra comments here to help explain the reasoning"></textarea>
                    </div>
                    <div class="field">
                        <label for="evidence">Evidence document</label>
                        <input type="url" value="{{ old('evidence') }}" name="evidence" id="evidence" placeholder="URL to evidence document">
                    </div>
                    <div class="ui message">
                        Image evidence can be attached to the ban after you have submitted it.
                    </div>
                </div>
                <button type="submit" class="ui primary button">Create Ban</button>
            </form>
        </div>
    </div>
    <script>
        $('.selection.dropdown')
            .dropdown()
        ;

        flatpickr('#start_at', {
            enableTime: true,
            noCalendar: false,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            defaultDate: '{{ old('start_at') ?? null }}'
        });

        flatpickr('#end_at', {
            enableTime: true,
            noCalendar: false,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            defaultDate: '{{ old('end_at') ?? null }}'
        });

        $('.ui.checkbox')
            .checkbox()
        ;
    </script>
@endsection
