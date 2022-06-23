<?php

namespace App\Http\Controllers\ModerationActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBanRequest;
use App\Http\Requests\UpdateBanRequest;
use App\Models\ModerationActions\Ban;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BansController extends Controller
{
    public function index()
    {
        return view('site.moderation-actions.bans.index', [
            'currentBans' => Ban::current()->get(),
            'permanentBans' => Ban::permanent()->get(),
            'expiredBans' => Ban::expired()->get(),
            '_pageTitle' => 'View Bans'
        ]);
    }

    public function create()
    {
        return view('site.moderation-actions.bans.create', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            '_pageTitle' => 'Create Ban'
        ]);
    }

    public function store(StoreBanRequest $request)
    {
        /**
         * Create ban with safe validation input
         */
        $ban = new Ban(array_merge(['id' => Str::uuid()], $request->except(['permanent', 'user_can_appeal'])));

        /** Process the checkboxes */
        if ($request->has('permanent') && $request->get('permanent') == 'on') {
            $ban->permanent = true;
        }
        if ($request->has('user_can_appeal') && $request->get('user_can_appeal') == 'on') {
            $ban->user_can_appeal = true;
        }

        /** Save and redirect */
        $ban->save();
        session()->flash('top-positive-msg', 'Ban created!');
        return redirect()->route('site.moderation-actions.bans.show', $ban);
    }

    public function show(Ban $ban)
    {
        return view('site.moderation-actions.bans.show', [
            'ban' => $ban,
            '_pageTitle' => "Ban of $ban->reddit_username"
        ]);
    }

    public function edit(Ban $ban)
    {
        return view('site.moderation-actions.bans.edit', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            'ban' => $ban,
            '_pageTitle' => "Edit Ban of $ban->reddit_username"
        ]);
    }

    public function update(UpdateBanRequest $request, Ban $ban)
    {
        /**
         * Create ban with safe validation input
         */
        $ban->update($request->except(['permanent', 'user_can_appeal']));

        /** Process the checkboxes */
        if ($request->has('permanent') && $request->get('permanent') == 'on') {
            $ban->permanent = true;
        } else {
            $ban->permanent = false;
        }
        if ($request->has('user_can_appeal') && $request->get('user_can_appeal') == 'on') {
            $ban->user_can_appeal = true;
        } else {
            $ban->user_can_appeal = false;
        }

        /** Save and redirect */
        $ban->save();
        session()->flash('top-positive-msg', 'Ban edited!');
        return redirect()->route('site.moderation-actions.bans.show', $ban);
    }

    public function destroy(Ban $ban)
    {
        //
    }
}
