@extends('layouts.master')
@section('title', 'Warning - '.$warning->reddit_username.' - ')
@section('content')
@php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
@endphp
<a href="{{route('actions.viewallwarnings')}}">◀ View Warnings</a><br>
<h1 class="ui header">Warning: {{$warning->reddit_username}} ({{Carbon\Carbon::create($warning->timestamp)->toDateString()}})</h1>
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
                        <a class="header" href="https://reddit.com/u/{{$warning->reddit_username}}">/u/{{$warning->reddit_username}}</a>
                        </div>
                    </div>
                    <div class="item">
                        <i class="discord icon"></i>
                        <div class="content">
                            {{$warning->discord_user_id}}
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
                            @foreach ($warning->moderator->roles as $r)
                            <i style="color:{{$r->colour}}" class="circle icon"></i>
                            @endforeach
                            {{$warning->moderator->username}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui fluid card">
            <div class="content">
                <div class="header" style="margin-bottom: 10px;">Actions</div>
                <div class="ui fluid vertical buttons">
                    @can('edit warning')
                    <a href="#" class="ui button">Edit Warning</a>
                    @endcan
                    <a href="#" id="exportB" class="ui button">Export</a>
                    <script>
                        $(document).on("click", "#exportB", function(){
                            $('#exportModal')
                                .modal('show')
                            ;
                        });
                    </script>
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
                <div class="header">Warning Details</div>
                <div class="ui list">
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Timestamp</div>
                            {{Carbon\Carbon::create($warning->timestamp)->toDayDateTimeString()}} GMT
                        </div>
                    </div>
                    <div class="item">
                        <i class="calendar icon"></i>
                        <div class="content">
                            <div class="header">Muted time</div>
                            {{$warning->muted_minutes}} minutes
                        </div>
                    </div>
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
                            <div class="header">Reason</div>
                            {{$warning->reason}}
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Evidence</div>
                            <a href="{{$warning->evidence}}">{{$warning->evidence}}</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="content">
                            <div class="header">Comments</div>
                            @if($warning->comments)
                            <p>{{$warning->comments}}</p>
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
        <p>
            This is an informal warning regarding your behaviour in the MHOC Main Server. This has been issued because <span class="ui red text">{{$warning->reason}}.</span> @if($warning->muted_minutes > 0) Subsequently, you have been muted in the Server for <span class="ui red text">{{$warning->muted_minutes}}</span> minutes to allow the situation to calm down / you to consider the potential ramifications should you continue with this behaviour. @endif
        </p>
        <p>
            This is a precautionary measure and will have no bearing on you moving forward. However, we ask that you take this warning seriously and adjust your behaviour upon your return to prevent you from breaking any rules and subsequently receiving a formal strike.
        </p>
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
                <textarea name="" readonly style="width:100%; height: 200px;" id="" cols="30" rows="10">{{$warning->toJson()}}</textarea>
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
@endsection
