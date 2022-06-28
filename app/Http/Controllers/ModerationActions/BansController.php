<?php

namespace App\Http\Controllers\ModerationActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\OverturnBanRequest;
use App\Http\Requests\StoreBanRequest;
use App\Http\Requests\UpdateBanRequest;
use App\Models\ModerationActions\Ban;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BansController extends Controller
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        //Authorise
        $this->authorize('viewAny', Ban::class);

        return view('site.moderation-actions.bans.index', [
            'currentBans' => Ban::current()->get(),
            'permanentBans' => Ban::permanent()->get(),
            'expiredBans' => Ban::expired()->get(),
            'overturnedBans' => Ban::overturned()->get(),
            '_pageTitle' => 'View Bans'
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        // Authorise
        $this->authorize('create', Ban::class);

        // Return view
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

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Ban $ban)
    {
        // Authorise
        $this->authorize('view', $ban);

        // Return view
        return view('site.moderation-actions.bans.show', [
            'ban' => $ban,
            '_pageTitle' => "Ban of $ban->reddit_username"
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Ban $ban)
    {
        // Authorise
        $this->authorize('update', $ban);

        // Return view
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

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Ban $ban)
    {
        // Authorise
        $this->authorize('delete', $ban);

        if ($ban->trashed()) {
            abort(403, 'Already trashed');
        }

        $ban->delete();

        session()->flash('top-info-msg', 'Ban deleted.');
        return redirect()->route('site.moderation-actions.bans.index');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function overturn(OverturnBanRequest $request, Ban $ban)
    {
        /**
         * Authorise based off permanency
         */
        if ($ban->permanent) {
            $this->authorize('overturnPermanent', $ban);
        } else {
            $this->authorize('overturn', $ban);
        }

        /**
         * Update ban with overturn details and save
         */
        $ban->update([
            'overturned' => true,
            'overturned_by_user_id' => $request->user()->id,
            'overturned_at' => now()->roundMinute(),
            'overturned_reason' => $request->get('reason'),
            $ban->update(['end_at' => now()->roundMinute()])
        ]);
        if ($ban->permanent) {
            $ban->update(['permanent' => false]);
        }
        $ban->save();

        /** Return and flash message */
        session()->flash('top-info-msg', 'Ban overturned.');
        return redirect()->route('site.moderation-actions.bans.show', $ban);
    }
}
