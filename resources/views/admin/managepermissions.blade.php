@extends('layouts.master')
@section('content')
<a href="{{route('dash')}}">◀ Dashboard</a><br>
<h1 class="ui huge header">Manage Permissions</h1>
<div class="ui stackable three column grid">
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">View User</div>
                <br>
                <div class="ui form">
                    <form id="searchUserForm">
                        @csrf
                        <div class="field">
                            <label for="">Search for a user</label>
                            <div class="ui fluid search">
                                <div class="ui icon input">
                                    <input class="prompt" name="user" type="text" placeholder="Search users...">
                                    <i class="search icon"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="ui message" id="searchUserMsg" style="display:none">
                        <div class="header">
                        </div>
                        <p></p>
                    </div>
                    <br>
                    <div id="searchUserResults"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="ui fluid card">
            <div class="content">
                <div class="header">Assign Role</div>
                <br>
                <div class="ui form">
                    <form action="" id="assignRoleForm" method="POST">
                    @csrf
                    <div class="field">
                        <label>Search for a user</label>
                        <div class="ui fluid search">
                            <div class="ui icon input">
                                <input class="prompt" name="user" type="text" placeholder="Search users...">
                                <i class="search icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label for="">Role</label>
                        <div class="ui fluid search selection dropdown" id="modIssuingDropdown">
                            <input type="hidden" name="role">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select</div>
                            <div class="menu">
                                @foreach ($roles as $r)
                                <div class="item" data-value="{{$r->name}}"><i style="color:{{$r->colour}}" class="circle icon"></i> {{ucfirst($r->name)}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="ui message" id="assignRoleMsg" style="display:none">
                        <div class="header">
                        </div>
                        <p></p>
                    </div>
                    <br>
                    <div class="field">
                        <button onclick="submitAssignRoleForm()" id="submitAssignRoleFormB" class="ui fluid elastic primary button">Assign Role</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function submitAssignRoleForm() {
        $("#submitAssignRoleFormB").toggleClass('loading');
        let data = $("#assignRoleForm").serializeArray();
        $.ajax({
            type: 'POST',
            url: '{{route('admin.assignrole')}}',
            data: {role:data[2].value, user:data[1].value},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': data[0].value
            },
            success: function(data) {
                console.log(data)
                $("#submitAssignRoleFormB").toggleClass('loading');
                $("#assignRoleMsg").addClass('green').removeClass('error').show();
                $("#assignRoleMsg .header").text(null)
                $("#assignRoleMsg p").text(data.message);
            },
            error: function(data) {
                $("#submitAssignRoleFormB").toggleClass('loading');
                $("#assignRoleMsg").addClass('error').removeClass('green').show();
                $("#assignRoleMsg .header").text('There were some errors')
                $("#assignRoleMsg p").text(data.responseJSON.message);
            }
        })
    }

    function removeRole(name, role) {
        $.ajax({
            type: 'POST',
            url: '{{route('admin.removerole')}}',
            data: {user:name, role:role},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            success: function (data) {
                alert('Removed role!')
                $("#searchUserResultsRole"+role).remove()
            },
            error: function (data) {
                alert('Error removing role: ' + data.responseJSON.message)
            }
        })
    }

    $('#modIssuingDropdown')
    .dropdown({
        onChange: function(value, text, $selectedItem) {
            console.info(value);
        }
    })
    ;
    var content = [
    @foreach($users as $u)
    {  title: '{{$u->username}}'  },
    @endforeach
    // etc
    ];
    $('#assignRoleForm .ui.search')
    .search({
        source: content,
        onSelect(result, response) {
            console.log(result)
        }
    })
    ;

    $("#searchUserForm .ui.search").search({
        source: content,
        onSelect(result, response) {
            if(result == null) return;
            $("#searchUserForm .ui.search").toggleClass('elastic loading disabled');
            let data = $("#searchUserForm").serializeArray();
            console.log(data)
            $.ajax({
            type: 'POST',
            url: '{{route('admin.searchuserinfo')}}',
            data: {user:data[1].value},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': data[0].value
            },
            success: function(data) {
                console.log(data)
                $("#searchUserForm .ui.search").toggleClass('elastic loading disabled');
                $("#searchUserResults").html(
                    `
                    <div class="ui list roles">
                    </div>
                    `
                )
                for (var i = 0; i < data.roles.length; i++) {
                    let role = data.roles[i];
                    let item = $("<div></div>").addClass('item').attr('id', 'searchUserResultsRole'+role.name);
                    $(item).html(`
                    <div class="content">
                        <div class="header">Role</div>
                        <i class="circle icon" style="color:${role.colour}"></i> ${role.name.charAt(0).toUpperCase() + role.name.slice(1)} <a href="#" onclick="removeRole('${data.user.username}', '${role.name}')" class="removeRoleLink" data-content="Remove role"><span class="ui red text"><i class="times icon"></i></span></a>
                    </div>`)
                    $("#searchUserResults .ui.list.roles").append(item);
                    $(".removeRoleLink").popup();
                }
                if (data.roles.length < 1) {
                    $("#searchUserResults .ui.list.roles").text('No roles.');
                }
            },
            error: function(data) {
                $("#searchUserForm .ui.search").toggleClass('elastic loading disabled');
                $("#searchUserMsg").addClass('error').removeClass('green').show();
                $("#searchUserMsg .header").text('There were some errors')
                $("#searchUserMsg p").text(data.responseJSON.message);
            }
        })
        }
    })

</script>
@endsection
