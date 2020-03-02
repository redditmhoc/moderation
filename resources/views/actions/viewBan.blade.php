@extends('layouts.master')
@section('title', 'Ban - '.$ban->reddit_username.' - ')
@section('content')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
@php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
@endphp
<a href="{{route('actions.viewallbans')}}">◀ View Bans</a><br>
<h1 class="ui header">Ban: {{$ban->reddit_username}} ({{Carbon\Carbon::create($ban->start_timestamp)->toDateString()}})</h1>
@if($ban->current())
<div class="ui info message">
    <div class="header">This ban will end in {{Carbon\Carbon::create($ban->end_timestamp)->diffForHumans()}}.</div>
</div>
@elseif($ban->permanent())
<div class="ui negative message">
    <div class="header">This is a permanent ban.</div>
</div>
@endif
@if($ban->overturned)
<div class="ui info message">
    <div class="header">This ban has been overturned.</div>
</div>
@endif
@if ($errors->overturnBan->any())
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
@endif
<br>
<div class="ui stackable three column grid">
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">User Information</div>
                <div class="ui list">
                    <div class="item">
                        <i class="reddit icon"></i>
                        <div class="content">
                        <a class="header" href="https://reddit.com/u/{{$ban->reddit_username}}">/u/{{$ban->reddit_username}}</a>
                        </div>
                    </div>
                    <div class="item">
                        <i class="discord icon"></i>
                        <div class="content">
                            {{$ban->discord_user_id}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Issued by</div>
                <div class="ui list">
                    <div class="item">
                        <i class="user icon"></i>
                        <div class="content">
                            @foreach ($ban->moderator->roles as $r)
                            <i style="color:{{$r->colour}}" class="circle icon"></i>
                            @endforeach
                            {{$ban->moderator->username}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui fluid card">
            <div class="content">
                <div class="header" style="margin-bottom: 10px;">Actions</div>
                <div class="ui fluid vertical buttons">
                    @can('edit ban')
                    <a href="#" class="ui button">Edit Ban</a>
                    @endcan
                    <a href="#" id="exportB" class="ui button">Export</a>
                    <script>
                        $(document).on("click", "#exportB", function(){
                            $('#exportModal')
                                .modal('show')
                            ;
                        });
                    </script>
                    @can('overturn ban')@if(!$ban->overturned)
                    <a href="#" id="overturnB" class="ui red button">Overturn Ban</a>
                    <script>
                        $(document).on("click", "#overturnB", function(){
                            $('#overturnBanModal')
                                .modal('show')
                            ;
                        });
                    </script>
                    @endif
                    @endcan
                    <a href="#" id="viewNotificationTemplateB" class="ui primary button">View Notification Template</a>
                    <script>
                        $(document).on("click", "#viewNotificationTemplateB", function(){
                            $('#notificationTemplateModal')
                                .modal('show')
                            ;
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Ban Details</div>
                <div class="ui list">
                    <div class="item">
                        <i class="tachometer alternate icon"></i>
                        <div class="content">
                            <div class="header">Level</div>
                            {{ordinal($ban->strike_level)}} Strike
                        </div>
                    </div>
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Started at</div>
                            {{Carbon\Carbon::create($ban->start_timestamp)->toDayDateTimeString()}} GMT
                        </div>
                    </div>
                    @if(!$ban->permanent())
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Ends at</div>
                            {{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT
                        </div>
                    </div>
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Total duration</div>
                            {{$ban->duration()}} day(s)
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if($ban->overturned)
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Overturn Details</div>
                <div class="ui list">
                    <div class="item">
                        <i class="user icon"></i>
                        <div class="content">
                            <div class="header">Person responsible</div>
                            @foreach ($ban->overturnModerator->roles as $r)
                            <i style="color:{{$r->colour}}" class="circle icon"></i>
                            @endforeach
                            {{$ban->overturnModerator->username}}
                        </div>
                    </div>
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Timestamp</div>
                            {{Carbon\Carbon::create($ban->overturned_timestamp)->toDayDateTimeString()}} GMT
                        </div>
                    </div>
                    <div class="item">
                        <i class="comments icon"></i>
                        <div class="content">
                            <div class="header">Comments</div>
                            {{$ban->overturned_comments}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Reasoning and Evidence</div>
                <div class="ui list">
                    <div class="item">
                        <div class="content">
                            <div class="header">Reason</div>
                            {{$ban->reason}}
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Evidence</div>
                            <a href="{{$ban->evidence}}">{{$ban->evidence}}</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Comments</div>
                            @if($ban->comments)
                            <p>{{$ban->comments}}</p>
                            @else
                            None provided.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ui modal" id="notificationTemplateModal">
    <div class="header">Notification template</div>
    <div class="content">
        @switch($ban->strike_level)
        @case(1)
        <p>
            This is a notice to inform you of your first strike on the MHOC Main Server. This subsequently means that you have been banned from the server for 24 hours, and will be on probation for a period of 30 days following your return. Your return date will be <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT</span>, and so your probationary period will end <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->addDays($ban->probation_length)->toDayDateTimeString()}}</span> (30 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        @break
        @case(2)
        <p>
            This is a notice to inform you of your second strike on the MHOC Main Server. This subsequently means that you have been banned from the server for 7 days, and will be on probation for a period of 90 days following your return. Your return date will be <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT</span>, and so your probationary period will end <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->addDays($ban->probation_length)->toDayDateTimeString()}}</span> (90 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        <div class="ui horizontal divider">
        Or for immediate 2nd strike
        </div>
        <p>
            This is a notice to inform you of your second strike on the MHOC Main Server. Despite not having a received a 1st strike prior to this, it was decided within the Discord Moderation Team that your actions have warranted an instant 2nd strike. This subsequently means that you have been banned from the server for 7 days, and will be on probation for a period of 90 days following your return. Your return date will be <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT</span>, and so your probationary period will end <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->addDays($ban->probation_length)->toDayDateTimeString()}}</span> (90 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        @break
        @case (3)
        <p>
            This is a notice to inform you of your third strike, and thus final warning, on the MHOC Main Server. This subsequently means that you have been banned from the server for quad to determine days / months, and will be on probation for a period of 180 days following your return. Your return date will be <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT</span>, and so your probationary period will end <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->addDays($ban->probation_length)->toDayDateTimeString()}}</span> (180 days following return).
        </p>
        <p>
            I must note that a fourth active strike can result in your permanent ban from the MHOC Main Server.
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        @break
        @case(4)
        <p>
            This is a notice to inform you of your fourth strike on the MHOC Main Server. This subsequently means that you have been permanently banned from the server.
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        <div class="ui horizontal divider">
            or for no permanent ban
        </div>
        <p>
            This is a notice to inform you of your fourth strike on the MHOC Main Server. A fourth active strike would normally warrant a permanent ban from the server, but following a review of your recent behaviour, the circumstances surrounding this strike, and for other reasons, we have decided to not issue you with a permanent ban.
        </p>
        <p>
            However, we must stress that if you were to commit another offence under MHOC’s Discord policy, it is highly likely that your chances of avoiding a permanent ban would be extremely minimal.
        </p>
        <p>
            As previously stated you will not receive a permanent ban for this strike but you will be dealt the punishment as would apply if this was a 3rd strike which is a ban of <span class="ui red text">{{$ban->duration()}} days</span> and a probation period upon your return of 180 days - a restart of your current probationary period. Your return date will be <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->toDayDateTimeString()}} GMT</span>, and so your probationary period will end <span class="ui red text">{{Carbon\Carbon::create($ban->end_timestamp)->addDays($ban->probation_length)->toDayDateTimeString()}}</span> (180 days following return).
        </p>
        <p>
            You received this strike because you <span class="ui red text">{{$ban->reason}}.</span> Evidence for this is linked below.
        </p>
        <p>
            If you have any queries about this strike and what it means, or if you wish to appeal this decision, then please contact the Quadrumvirate via mod-mail to /r/MHOCQuad.
        </p>
        <p>
            <span class="ui red text">{{$ban->evidence}}</span>
        </p>
        @endswitch
    </div>
</div>
<div class="ui modal" id="exportModal">
    <div class="header">Export ban</div>
    <div class="content">
        <p>You can export the ban information to CSV, XML, or JSON. Not sure why you'd want to though...</p>
        <br>
        <div class="ui styled fluid accordion">
            <div class="title">
                <i class="dropdown icon"></i>
                Export to CSV
            </div>
            <div class="content">
                not implemented yet
            </div>
            <div class="title">
                <i class="dropdown icon"></i>
                Export to JSON
            </div>
            <div class="content">
                <textarea name="" readonly style="width:100%; height: 200px;" id="" cols="30" rows="10">{{$ban->toJson()}}</textarea>
            </div>
            <div class="title">
                <i class="dropdown icon"></i>
                Export to XML
            </div>
            <div class="content">
                Not done yet either smh
            </div>
        </div>
        <script>
            $('.ui.accordion')
        .accordion()
        ;
        </script>
    </div>
</div>
@can('overturn ban')
<div class="ui modal" id="overturnBanModal">
    <div class="header">Overturn ban</div>
    <div class="content">
        <p>Overturning a ban will reduce the ban to the current time and attempt to unban the user on Discord and Reddit.</p>
        <div class="ui form">
            <form action="{{route('actions.overturnban', [$ban->reddit_username, $ban->id])}}" method="POST" id="overturnForm">
            @csrf
            <div class="required field">
                <label for="">Comments</label>
                <div class="ui input">
                    <textarea name="comments" id="" cols="30" style="width:100%; height: 100px;" rows="10"></textarea>
                </div>
            </div>
            <div class="required field">
                <label for="">Person responsible for overturning ban</label>
                <div class="ui fluid search selection dropdown" id="modIssuingDropdown">
                    <input type="hidden" value="{{Auth::user()->id}}" name="personResponsible">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select</div>
                    <div class="menu">
                        @foreach ($admins as $m)
                        <div class="item" data-value="{{$m->id}}">@foreach ($m->roles as $r) <i style="color:{{$r->colour}}" class="circle icon"></i>@endforeach{{$m->username}}</div>
                        @endforeach
                    </div>
                </div>
                <script>
                    $('#modIssuingDropdown')
                    .dropdown({
                        onChange: function(value, text, $selectedItem) {
                            console.info(value);
                        }
                    })
                    ;
                </script>
            </div>
            </form>
            <br>
            <button id="submitOverturnB" onclick="submitForm()" class="ui red button">Overturn Ban</button>
            <script>
                function submitForm () {
                    $("#submitOverturnB").toggleClass('elastic loading');
                    $("#overturnForm").submit();
                }
            </script>
        </div>
    </div>
</div>
</div>
</div>
@endcan
@endsection
