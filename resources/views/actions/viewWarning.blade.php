@extends('layouts.master')
@section('title', 'Warning - '.$warning->reddit_username.' - ')
@section('content')
@include('layouts.navbar')
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
                    @can('edit actions')
                    <a href="#" class="ui button" id="editB">Edit Warning</a>
                    <script>
                        $(document).on("click", "#editB", function(){
                            $('#editModal')
                                .modal('show')
                            ;
                        });
                    </script>
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
                            <div class="header">Comments / Evidence</div>
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

<!--Start Notification Template Modal-->
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
<!--End Notification Template Modal-->

<!--Start Export Modal-->
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
<!--End Export Modal-->
@can('edit actions')
<!--Start Edit Modal-->
<div class="ui modal" id="editModal">
    <div class="header">Edit warning</div>
    <div class="content">
        <p>Last updated at {{$warning->updated_at->toDayDateTimeString()}} GMT
        </p>
        <form action="{{route('actions.editwarning.post', [$warning->reddit_username, $warning->id])}}" method="POST" class="ui form" id="editForm">
            @csrf
            <h5 for="">Discord User ID</h5>
            <div class="field">
                <input type="text" value="{{$warning->discord_user_id}}" name="discordUserId">
                <script>
                    $(document).on("click", "#discordIDModalB", function(){
                        $('#discordIDModal')
                            .modal('show')
                        ;
                    });
                </script>
            </div>
            <h5>Time and date</h5>
            <input value="{{$warning->timestamp}}" type="datetime" name="timeDateIssued" class="flatpickr" id="timeDateIssued">
            <script>
                flatpickr('#timeDateIssued', {
                    enableTime: true,
                    noCalendar: false,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                });
            </script>
            <h5 for="">Time muted in minutes</h5>
            <div class="field">
                <div class="ui input">
                    <input value="{{$warning->muted_minutes}}" type="number" name="muted_minutes" id="" max="120" min="0" value="0" placeholder="0">
                </div>
            </div>
            <h5 for="">Reason for warning</h5>
            <div class="field">
                <div class="ui fluid search selection dropdown" id="strikeReasonDropdown">
                    <input type="hidden" value="{{$warning->reason}}" name="reason">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select a reason</div>
                    <div class="menu">
                        <div class="item" data-value="Used discriminative language">
                            Used discriminative language
                        </div>
                        <div class="item" data-value="Personally insulted/attacked another member of the community">
                            Personally insulted/attacked another member of the community
                        </div>
                        <div class="item" data-value="Used vile and disturbing language">
                            Used vile and disturbing language
                        </div>
                        <div class="item" data-value="Doxxed another member of the community or an associated community">
                            Doxxed another member of the community or an associated community
                        </div>
                        <div class="item" data-value="Shared NSFW content">
                            Shared NSFW content
                        </div>
                        <div class="item" data-value="Spam">
                            Spam
                        </div>
                        <div class="item" data-value="Aggressive behaviour">
                            Aggressive behaviour
                        </div>
                        <div class="item" data-value="Deliberately tried to circumvent the rules">
                            Deliberately tried to circumvent the rules
                        </div>
                        <div class="item" data-value="Other">
                            Other (specified in comments)
                        </div>
                    </div>
                </div>
                <script>
                    $('#strikeReasonDropdown')
                    .dropdown({
                        onChange: function(value, text, $selectedItem) {
                            console.info(value);
                        }
                    })
                    ;
                </script>
            </div>
            <h5 for="">Comments / Evidence</h5>
            <div class="field">
                <div class="ui input">
                    <textarea style="width: 100%; height: 100px;" name="comments" id="" cols="30" rows="10">{{$warning->comments}}</textarea>
                </div>
            </div>
            <br>
            <button id="submitEditB" onclick="submitForm()" class="ui primary button">Submit Edit</button>
            <script>
                function submitForm () {
                    $("#submitEditB").toggleClass('elastic loading');
                    $("#editForm").submit();
                }
            </script>
        </form>
    </div>
</div>
<!--End Edit Modal-->
@endcan
</div>
</div>
@endsection
