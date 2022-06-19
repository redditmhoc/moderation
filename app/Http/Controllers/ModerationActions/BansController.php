<?php

namespace App\Http\Controllers\ModerationActions;

use App\Http\Controllers\Controller;
use App\Models\ModerationActions\Ban;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }

    public function update(Request $request, Ban $ban)
    {
        //
    }

    public function destroy(Ban $ban)
    {
        //
    }
}
