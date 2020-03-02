/*
Create Action scripts
Scripts used on create ban/warning pages
*/

/* Check History Of user */

function checkUserHistory(user) {

    $("#userHistoryContainer").html(`
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
        $("#userHistoryContainer").html(`
        <div class="ui error message">
            Error: ${data.responseJSON.message}
        </div>
        `)
    }
    })
}

console.info('Create Action scripts loaded')
