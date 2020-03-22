@extends('layouts.master')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<a href="{{route('actions.viewallbans')}}">◀ View Bans</a><br>
<h1 class="ui header">Create Ban</h1>
@if ($errors->any())
<div class="ui error message">
    <div class="header">
        There were some errors with your submission
    </div>
    <div class="ui bulleted list">
    @foreach ($errors->all() as $e)
        <div class="item">
            {{$e}}
        </div>
    @endforeach
    </div>
</div>
@endif
<div class="ui form">
    <form action="{{route('actions.createban.post')}}" method="POST" id="form">
    @csrf
    <h4 class="ui horizontal left aligned divider header">
        User Information
    </h4>
    <div class="required field">
        <label for="">Reddit username</label>
        <input onblur="checkUserHistory(this.value)" required type="text" name="redditUsername" placeholder="Without the /u/">
        <div style="margin-top: 10px;" id="userHistoryContainer"></div>
    </div>
    <script>


    </script>
    <div class="required field">
        <label for="">Discord User ID</label>
        <input required type="text" name="discordUserId">
        <a href="#" id="discordIDModalB">(How do I get this?)</a>
        <script>
            $(document).on("click", "#discordIDModalB", function(){
                $('#discordIDModal')
                    .modal('show')
                ;
            });
        </script>
    </div>
    <h4 class="ui horizontal left aligned divider header">
        Strike
    </h4>
    <div class="required field">
        <label for="">Strike Level</label>
        <div class="ui selection dropdown" id="strikeLevelDropdown">
            <input type="hidden" required name="strikeLevel">
            <i class="dropdown icon"></i>
            <div class="default text">Select level</div>
            <div class="menu">
                <div class="item" data-value="1">1st Strike</div>
                <div class="item" data-value="2">2nd Strike</div>
                <div class="item" data-value="3">3rd Strike</div>
                <div class="item" data-value="4">4th Strike</div>
                @can('permanent ban')
                <div class="item" data-value="5">4th Strike (Permanent)</div>
                @endcan
            </div>
        </div>
    </div>
    <div class="field">
        <label for="">Length (in days)</label>
        <div class="ui disabled input" id="strikeLengthInputContainer">
            <input id="strikeLengthInput" name="strikeLength" type="number">
        </div>
        <p>This is set automaticaly for 1st and 2nd strike levels.</p>
    </div>
    <script>
        $('#strikeLevelDropdown')
        .dropdown({
            onChange: function(value, text, $selectedItem) {
                console.info(value);
                if (value > 2 && value < 5) {
                    console.log('Enabling length input...')
                    $("#strikeLengthInputContainer").removeClass('disabled');
                    $("#strikeLengthInput").val(28);
                } else {
                    $("#strikeLengthInputContainer").addClass('disabled');
                    if (value == 1) {
                        $("#strikeLengthInput").val(1);
                    } else if (value == 2) {
                        $("#strikeLengthInput").val(7);
                    } else {
                        $("#strikeLengthInput").val(null);
                    }
                }
            }
        })
        ;
    </script>
    <h4 class="ui horizontal left aligned divider header">
        Issued
    </h4>
    <div class="required field">
        <label for="">Mod issuing strike</label>
        <div class="ui fluid search selection dropdown" id="modIssuingDropdown">
            <input type="hidden" value="{{Auth::user()->id}}" name="modIssuing">
            <i class="dropdown icon"></i>
            <div class="default text">Select</div>
            <div class="menu">
                @foreach ($moderators as $m)
                <div class="item" data-value="{{$m->id}}">@foreach ($m->roles as $r) <i style="color:{{$r->colour}}" class="circle icon"></i>@endforeach{{$m->username}}</div>
                @endforeach
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
    <h5>Time and date</h5>
    <p>You can leave this field blank and it will be computed automatically. Enter ALL times in GMT.</p>
    <input type="datetime" name="timeDateIssued" class="flatpickr" id="timeDateIssued">
    <script>
        flatpickr('#timeDateIssued', {
            enableTime: true,
            noCalendar: false,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
        });
    </script>
    <h4 class="ui horizontal left aligned divider header">
        Reasoning
    </h4>
    <div class="required field">
        <label for="">Reason for strike</label>
        <div class="ui fluid search selection dropdown" id="strikeReasonDropdown">
            <input type="hidden" value="" name="strikeReason">
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
    <div class="field">
        <label for="">Comments</label>
        <div class="ui input">
            <textarea style="width: 100%; height: 100px;" name="comments" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div class="required field">
        <label for="">Evidence</label>
        <div class="ui input">
            <input type="text" name="evidence" id="">
        </div>
        <p>Enter only 1 URL. For multiple images, use an Imgur album.</p>
    </div>
    <h4 class="ui horizontal left aligned divider header">
        Options
    </h4>
    <div class="ui checkbox">
        <input name="autoBanDiscord" type="checkbox">
        <label>Automatically ban user from main</label>
    </div>&nbsp;&nbsp;
    @can('subreddit ban')
    <div class="ui checkbox">
        <input name="subredditBan" type="checkbox">
        <label>Subreddit ban</label>
    </div>
    @endcan
    <br>
    <br>
    </form>
    <button id="submitButton" class="ui primary button" onclick="submitForm()">Submit Ban</button>
    <script>
        function submitForm () {
            $("#submitButton").toggleClass('elastic loading');
            $("#form").submit();
        }
    </script>
</div>
<div class="ui modal" id="discordIDModal">
    <div class="header">How to get a user's Discord UI</div>
    <div class="content">
      <p>
        <div class="ui bulleted list">
            <div class="item">Enable <b>Developer Mode</b> in the Discord settings.</div>
            <div class="item">Right click the user.</div>
            <div class="item">Click <b>Copy ID</b></div>
        </div>
        <br>
        <a href="https://support.discordapp.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-">Read more here.</a>
      </p>
    </div>
  </div>
</div>
</div>
@endsection
