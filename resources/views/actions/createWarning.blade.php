@extends('layouts.master')
@section('content')
@include('layouts.navbar')
<div style="margin-top: 10px; margin-bottom: 10px;" class="ui grid container">
<div class="eight column wide">
<a href="{{route('actions.viewallwarnings')}}">◀ View Warnings</a><br>
<h1 class="ui header">Create Warning</h1>
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
    <form action="{{route('actions.createwarning.post')}}" method="POST" id="form">
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
        var getGetOrdinal = function(n) {
            var s=["th","st","nd","rd"],
                v=n%100;
            return n+(s[(v-20)%10]||s[v]||s[0]);
        }

        function checkUserHistory(user) {
            $("#userHistoryContainer").html(`
                <div class="ui message">
                    <div class="ui active inline loader"></div>&nbsp;&nbsp;Checking history for /u/${user}....
                </div>
            `)
            $.ajax({
            type: 'POST',
            url: '{{route('utility.checkuserhistory')}}',
            data: {reddit_username:user},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            success: function(data) {
                console.info(data)
                if (data.bans.length < 1 && data.warnings.length < 1) {
                    $("#userHistoryContainer").html(`
                        <div class="ui message">
                        No history found for /u/${user}.
                        </div>
                    `)
                } else {
                    $("#userHistoryContainer").html(`
                        <div class="ui negative message">
                            <div class="header">History found</div>
                            <div class="ui bulleted list ${user}-history-list">
                            </div>
                        </div>
                    `)
                    console.log(data.bans[0])
                    data.bans.forEach(ban => {
                        let item = $('<div></div>').addClass('item').html(
                            `
                            <div class="content">
                                ${getGetOrdinal(ban.strike_level)} Strike - ${ban.start_timestamp} - <a href="/actions/view/ban/${ban.reddit_username}/${ban.id}">View</a>
                            </div>
                            `
                        )
                        $(`#userHistoryContainer .${user}-history-list`).append(item);
                    })
                    data.warnings.forEach(warning => {
                        let item = $('<div></div>').addClass('item').html(
                            `
                            <div class="content">
                                Warning - ${warning.timestamp} - <a href="/actions/view/warning/${warning.reddit_username}/${warning.id}">View</a>
                            </div>
                            `
                        )
                        $(`#userHistoryContainer .${user}-history-list`).append(item);
                    })
                }
            },
            error: function(data) {
                alert(data.responseJSON.message)
            }
            })
        }
    </script>
    <div class="field">
        <label for="">Discord User ID</label>
        <input type="text" name="discordUserId">
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
        Muted Period
    </h4>
    <div class="required field">
        <label for="">Time muted in minutes</label>
        <div class="ui input">
            <input type="number" name="muted_minutes" id="" max="120" min="0" value="0" placeholder="0">
        </div>
    </div>
    <h4 class="ui horizontal left aligned divider header">
        Reasoning
    </h4>
    <div class="required field">
        <label for="">Reason for warning</label>
        <div class="ui fluid search selection dropdown" id="strikeReasonDropdown">
            <input type="hidden" value="" name="reason">
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
        <label for="">Comments / Evidence</label>
        <div class="ui input">
            <textarea style="width: 100%; height: 100px;" name="comments" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
    <br><br>
    </form>
    <button id="submitButton" class="ui primary button" onclick="submitForm()">Submit Warning</button>
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
