<?php

namespace App\Http\Controllers;

use App\Models\Actions\Ban;
use App\Models\Actions\Warning;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActionsController extends Controller
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
            'discordUserId' => 'required',
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

        $ban->start_timestamp = $request->get('timeDateIssued') ? $request->get('timeDateIssued') : Carbon::now();

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

        return redirect()->route('actions.viewban', [$ban->reddit_username, $ban->id]);
    }

    public function createWarningPost(Request $request)
    {
        //Validate request
        $validator = Validator::make($request->all(), [
            'redditUsername' => 'required',
            'discordUserId' => 'required',
            'reason' => 'required',
            'evidence' => 'required',
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
            'evidence' => $request->get('evidence')
        ]);

        $warning->timestamp = $request->get('timeDateIssued') ? $request->get('timeDateIssued') : Carbon::now();

        $warning->save();

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
