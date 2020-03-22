<div class="ui container" style="margin-top: 20px;">
    <div class="ui secondary pointing menu">
        <a href="{{route('dash')}}" class="{{Request::is('dash') ? 'active' : ''}} item">
            Dashboard
        </a>
        {{-- <div class="ui dropdown item">
            Speakership
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="" class="item"><i class="mail icon"></i>Send Modmail</a>
            </div>
        </div> --}}
        @can('access')
        <div class="ui dropdown item">
            Moderation
            <i class="dropdown icon"></i>
            <div class="menu">
                {{-- <a href="#" class="item"><i class="mail icon"></i>Submit Complaint</a> --}}
                @can('view actions')
                <div class="divider"></div>
                <div class="header">Actions</div>
                <a href="{{route('actions.viewallbans')}}" class="{{Request::is('actions/view/bans') || Request::is('actions/view/ban/*') || Request::is('actions/create/ban') ? 'active' : ''}} item">Bans</a>
                <a href="{{route('actions.viewallwarnings')}}" class="{{Request::is('actions/view/warnings') || Request::is('actions/view/warning/*') || Request::is('actions/create/warning') ? 'active' : ''}} item">Warnings</a>
                <a id="viewUserHistoryB" href="#" class="item">User History</a>
                <script>
                    $(document).on("click", "#viewUserHistoryB", function(){
                        $('#userHistoryModal')
                            .modal('show')
                        ;
                    });
                </script>
                @endcan
                @can('access')
                <div class="divider"></div>
                <div class="header">Help</div>
                <a href="{{route('guidance')}}" class="{{Request::is('guidance') ? 'active' : ''}} item">Guidance & Templates</a>
                @endcan
            </div>
        </div>
        @endcan
        @role('admin')
        <div class="ui dropdown item">
            Admin
            <i class="dropdown icon"></i>
            <div class="menu">
                <a href="{{route('admin.managepermissions')}}" class="item">Manage Permissions</a>
            </div>
        </div>
        @endrole
        <div class="right menu">
            <a target="_blank" href="https://reddit.com/r/mhoc" class="ui item">Go to /r/mhoc</a>
            <div href="#" class="ui dropdown item">
                <i class="user icon"></i> <b>{{Auth::user()->username}}</b>
                <div class="menu">
                    <div class="header">
                        @foreach (Auth::user()->roles as $r)
                        <i style="color:{{$r->colour}}" class="circle icon"></i> {{ucfirst($r->name)}}
                        @endforeach
                    </div>
                    <a class="item" href="javascript:alert('This isn\'t available yet')"><i class="user icon"></i> View Your Data</a>
                    <a href="{{route('auth.logout')}}" class="item"><i class="key icon"></i> Sign Out</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(" .ui.dropdown").dropdown();
    </script>
</div>

@can('view actions')
<div class="ui modal" id="userHistoryModal">
    <div class="header">View user history</div>
    <div class="content">
        <p>Enter a reddit username to view moderation history.</p>
        <div class="ui form">
        <div class="required field">
            <label for="">Reddit username</label>
            <input onblur="checkUserHistoryModal(this.value)" required type="text" name="redditUsername" placeholder="Without the /u/">
            <div style="margin-top: 10px;" id="userHistoryContainerModal"></div>
        </div>
        </div>
        <script>
            function checkUserHistoryModal (user) {
            $("#userHistoryContainerModal").html(`
                <div class="ui message">
                    <div class="ui active inline loader"></div>&nbsp;&nbsp;Checking history for /u/${user}....
                </div>
            `)
            $.ajax({
            type: 'POST',
            url: '/utility/checkuserhistory',
            data: {reddit_username:user},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            },
            success: function(data) {
                if (data.bans.length < 1 && data.warnings.length < 1) {
                    $("#userHistoryContainerModal").html(`
                        <div class="ui message">
                        No history found for /u/${user}.
                        </div>
                    `)
                } else {
                    $("#userHistoryContainerModal").html(`
                        <div class="ui negative message">
                            <div class="header">History found</div>
                            <div class="ui bulleted list ${user}-history-list">
                            </div>
                        </div>
                    `)
                    data.bans.forEach(ban => {
                        let item = $('<div></div>').addClass('item').html(
                            `
                            <div class="content">
                                ${getGetOrdinal(ban.strike_level)} Strike - ${ban.start_timestamp} - <a href="/actions/view/ban/${ban.reddit_username}/${ban.id}">View</a>
                            </div>
                            `
                        )
                        $(`#userHistoryContainerModal .${user}-history-list`).append(item);
                    })
                    data.warnings.forEach(warning => {
                        let item = $('<div></div>').addClass('item').html(
                            `
                            <div class="content">
                                Warning - ${warning.timestamp} - <a href="/actions/view/warning/${warning.reddit_username}/${warning.id}">View</a>
                            </div>
                            `
                        )
                        $(`#userHistoryContainerModal .${user}-history-list`).append(item);
                    })
                }
            },
            error: function(data) {
                $("#userHistoryContainerModal").html(`
                <div class="ui error message">
                    Error: ${data.responseJSON.message}
                </div>
                `)
            }
            })
        }
        </script>
    </div>
</div>
@endcan
