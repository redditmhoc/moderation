<?php

namespace App\Http\Controllers\Moderation;

use App\Broadcasting\DiscordWebhookChannel;
use App\Models\Moderation\Actions\Ban;
use App\Models\Moderation\Actions\Warning;
use App\Models\User;
use App\Notifications\BanEndNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ActionsController extends \App\Http\Controllers\Controller
{
    public function createBan()
    {
        $moderators = User::permission('create ban')->get();
        $admins = User::role('admin')->get();
        return view('actions.createBan', compact('moderators', 'admins'));
    }

    public function createWarning()
    {
        $moderators = User::permission('create ban')->get();
        $admins = User::role('admin')->get();
        return view('actions.createWarning', compact('moderators', 'admins'));
    }

    public function createBanPost(Request $request)
    {
        //Validate request
        $validator = Validator::make($request->all(), [
            'redditUsername' => 'required',
            'strikeLevel' => 'required',
            'strikeReason' => 'required',
            'evidence' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $ban = new Ban([
            'reddit_username' => $request->get('redditUsername'),
            'discord_user_id' => $request->get('discordUserId'),
            'strike_level' => $request->get('strikeLevel'),
            'moderator_id' => $request->get('modIssuing'),
            'reason' => $request->get('strikeReason'),
            'comments' => $request->get('comments'),
            'evidence' => $request->get('evidence')
        ]);

        if ($request->get('timeDateIssued') == null) {
            $ban->start_timestamp = date('Y-m-d H:i:s');
        } else {
            $ban->start_timestamp = $request->get('timeDateIssued');
        }

        if ($request->get('strikeLength')) {
            $ban->end_timestamp = Carbon::create($ban->start_timestamp)->addDays($request->get('strikeLength'));
        }

        switch ($request->get('strikeLevel')) {
            case 1:
                $ban->probation_length = 7;
            break;
            case 2:
                $ban->probation_length = 30;
            break;
            case 3 || 4:
                $ban->probation_length = 90;
            break;
        }

        if ($request->get('autoBanDiscord') == 'on') {
            //TODO: bans
        }

        if ($request->get('subredditBan')) {
            $ban->subreddit_ban = true;
        }

        $ban->save();

        //Discord mod chat notification
        $hook = json_encode([
            "content" => null,
            "username" => "Moderation Bot",
            "avatar_url" => "https://gexiii.lieselta.live/img/mhoc.png",
            "tts" => false,
            "embeds" => [
                [
                    "title" => $ban->permanent() ? 'Permanent Ban | ' .$ban->reddit_username : $ban->ordinal().' Strike | '. $ban->reddit_username,
                    "description" => "Issued by ".$ban->moderator->username.' at '.$ban->start_timestamp.' GMT until '.$ban->end_timestamp.' GMT ('. $ban->duration() . ' days) for '.$ban->reason.'.',
                    "url" => route('actions.viewban', [$ban->reddit_username, $ban->id])
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init();
        curl_setopt_array( $ch, [
            CURLOPT_URL => config('services.discord.webhooks.discord_mods'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hook,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
            Log::error($error);
        }
        curl_close($ch);

        return redirect()->route('actions.viewban', [$ban->reddit_username, $ban->id]);
    }

    public function createWarningPost(Request $request)
    {
        //Validate request
        $validator = Validator::make($request->all(), [
            'redditUsername' => 'required',
            'reason' => 'required',
            'muted_minutes' => 'integer'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $warning = new Warning([
            'reddit_username' => $request->get('redditUsername'),
            'discord_user_id' => $request->get('discordUserId'),
            'muted_minutes' => $request->get('muted_minutes'),
            'moderator_id' => $request->get('modIssuing'),
            'reason' => $request->get('reason'),
            'comments' => $request->get('comments'),
        ]);

        $warning->timestamp = $request->get('timeDateIssued') ? $request->get('timeDateIssued') : Carbon::now();

        $warning->save();

        //Discord mod chat notification
        $hook = json_encode([
            "content" => null,
            "username" => "Moderation Bot",
            "avatar_url" => "https://gexiii.lieselta.live/img/mhoc.png",
            "tts" => false,
            "embeds" => [
                [
                    "title" => 'Warning | '. $warning->reddit_username,
                    "description" => "Issued by ".$warning->moderator->username.' at '.$warning->timestmap.' GMT (muted '.$warning->muted_minutes.' min) for '.$warning->reason.'.',
                    "url" => route('actions.viewwarning', [$warning->reddit_username, $warning->id])
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init();
        curl_setopt_array( $ch, [
            CURLOPT_URL => config('services.discord.webhooks.discord_mods'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hook,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
            Log::error($error);
        }
        curl_close($ch);

        return redirect()->route('actions.viewwarning', [$warning->reddit_username, $warning->id]);
    }

    public function checkUserHistoryAjax(Request $request)
    {
        //Check for potential bans
        $bans = Ban::where('reddit_username', $request->get('reddit_username'))->get();
        $warnings = Warning::where('reddit_username', $request->get('reddit_username'))->get();
        return response()->json(['bans' => $bans, 'warnings' => $warnings], 200);
    }

    public function viewBan($reddit_username, $id)
    {
        $admins = User::role('admin')->get();
        $ban = Ban::where('reddit_username', $reddit_username)->where('id', $id)->firstOrFail();
        return view('actions.viewBan', compact('ban', 'admins'));
    }

    public function viewWarning($reddit_username, $id)
    {
        $warning = Warning::where('reddit_username', $reddit_username)->where('id', $id)->firstOrFail();
        return view('actions.viewWarning', compact('warning'));
    }

    public function editWarningPost(Request $request, $reddit_username, $id)
    {
        //Find the warning
        $warning = Warning::where('reddit_username', $reddit_username)->where('id', $id)->firstOrFail();

        //Validate request
        $validator = Validator::make($request->all(), [
            'muted_minutes' => 'integer'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'editWarning');
        }

        //Edit the warning then I guess
        $warning->discord_user_id = $request->get('discordUserId');
        $warning->muted_minutes = $request->get('muted_minutes');
        $warning->reason = $request->get('reason');
        $warning->comments = $request->get('comments');
        $warning->timestamp = $request->get('timeDateIssued');
        $warning->save();

        return redirect()->back();
    }

    public function editBanPost(Request $request, $reddit_username, $id)
    {
        //Find the ban
        $ban = Ban::where('reddit_username', $reddit_username)->where('id', $id)->firstOrFail();

        //Validate request
        $validator = Validator::make($request->all(), [
            'evidence' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'editBan');
        }

        //Edit the ban then I guess
        $ban->discord_user_id = $request->get('discordUserId');
        $ban->reason = $request->get('reason');
        $ban->comments = $request->get('comments');
        $ban->evidence = $request->get('evidence');
        $ban->save();

        return redirect()->back();
    }

    public function overturnBan(Request $request, $reddit_username, $id)
    {
        //Find the ban
        $ban = Ban::where('reddit_username', $reddit_username)->where('id', $id)->firstOrFail();

        //Validate request
        $validator = Validator::make($request->all(), [
            'comments' => 'required',
            'personResponsible' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'overturnBan');
        }

        $ban->overturned = true;
        $ban->overturned_timestamp = Carbon::now();
        $ban->overturned_comments = $request->get('comments');
        $ban->overturned_moderator_id = $request->get('personResponsible');
        $ban->end_timestamp = Carbon::now();
        $ban->save();

        return redirect()->back();
    }

    public function viewAllBans()
    {
        $activeBans = Ban::cursor()->filter(function ($ban) {
            return $ban->current() && !$ban->permanent() && !$ban->overturn;
        })->sortByDesc('start_timestamp');

        $pastBans = Ban::cursor()->filter(function ($ban) {
            return !$ban->current();
        })->sortByDesc('start_timestamp');

        $permanentBans = Ban::cursor()->filter(function ($ban) {
            return $ban->permanent() && !$ban->overturn;
        })->sortByDesc('start_timestamp');

        $overturnedBans = Ban::cursor()->filter(function ($ban) {
            return $ban->overturned;
        })->sortByDesc('start_timestamp');

        return view('actions.viewBans', compact('activeBans', 'permanentBans', 'pastBans', 'overturnedBans'));
    }

    public function viewAllWarnings()
    {
        $warnings = Warning::all()->sortByDesc('start_timestamp');

        return view('actions.viewWarnings', compact('warnings'));
    }

    public function importBansFromFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);
        $uploadedFile = $request->file('file')->get();
        echo('Processing..');
        $bans = json_decode($uploadedFile);
        foreach($bans as $b) {
            echo('<br>');
            try {
                $ban = new Ban();
                $ban->reddit_username = $b->Username;
                $ban->discord_user_id = $b->DiscordID ? $b->DiscordID : null;
                $ban->strike_level = $b->StrikeLevel[0];
                $ban->start_timestamp = Carbon::createFromFormat('d/m/y H:i', $b->DateIssued.' '.$b->Time);
                $ban->end_timestamp = Carbon::createFromFormat('d/m/y H:i', $b->DateIssued.' '.$b->Time)->addDays(intval($b->BanLength));
                $ban->probation_length = $b->ProbationLength ? $b->ProbationLength : null;
                $mod = User::where('username', $b->Mod)->first();
                if ($mod) {
                    $ban->moderator_id = $mod->id;
                } else {
                    $mod = new User();
                    $mod->username = $b->Mod;
                    $mod->save();
                    $ban->moderator_id = $mod->id;
                }
                $ban->reason = $b->Reason;
                $ban->comments = $b->Comments;
                $ban->evidence = $b->Evidence;
                echo($ban);
                $ban->save();
            }
            catch (Exception $ex) {
                echo($ex);
            }
        }
    }
}
