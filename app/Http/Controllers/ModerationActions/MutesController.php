<?php

namespace App\Http\Controllers\ModerationActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMuteRequest;
use App\Http\Requests\UpdateMuteRequest;
use App\Models\ModerationActions\Mute;
use App\Models\User;
use Illuminate\Support\Str;

class MutesController extends Controller
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Mute::class);
        return view('site.moderation-actions.mutes.index', [
            'currentMutes' => Mute::current()->get(),
            'expiredMutes' => Mute::expired()->get(),
            '_pageTitle' => 'View Mutes'
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Mute::class);
        return view('site.moderation-actions.mutes.create', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            '_pageTitle' => 'Create Mute'
        ]);
    }

    public function store(StoreMuteRequest $request)
    {
        $mute = new Mute(array_merge(['id' => Str::uuid()], $request->validated()));
        $mute->save();
        session()->flash('top-positive-msg', 'Mute created!');
        return redirect()->route('site.moderation-actions.mutes.show', $mute);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Mute $mute)
    {
        $this->authorize('view', $mute);
        return view('site.moderation-actions.mutes.show', [
            'mute' => $mute,
            '_pageTitle' => "Mute of $mute->reddit_username"
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Mute $mute)
    {
        $this->authorize('update', $mute);
        return view('site.moderation-actions.mutes.edit', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            'mute' => $mute,
            '_pageTitle' => "Edit Mute of $mute->reddit_username"
        ]);
    }

    public function update(UpdateMuteRequest $request, Mute $mute)
    {
        $mute->update($request->validated());
        $mute->save();
        session()->flash('top-positive-msg', 'Mute updated!');
        return redirect()->route('site.moderation-actions.mutes.show', $mute);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Mute $mute)
    {
        $this->authorize('delete', $mute);
        if ($mute->trashed()) {
            abort(403, 'Already trashed');
        }
        $mute->delete();
        session()->flash('top-info-msg', 'Mute deleted.');
        return redirect()->route('site.moderation-actions.mutes.index');
    }
}
