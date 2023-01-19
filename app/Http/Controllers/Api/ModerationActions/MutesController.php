<?php

namespace App\Http\Controllers\Api\ModerationActions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMuteRequest;
use App\Http\Resources\ModerationActions\MuteResource;
use App\Models\ModerationActions\Mute;
use Illuminate\Http\Request;

class MutesController extends Controller
{
    public function index()
    {
        return MuteResource::collection(Mute::all()->sortByDesc('created_at'));
    }

    public function show(Mute $mute)
    {
        return MuteResource::make($mute);
    }

    public function store(StoreMuteRequest $request)
    {
        $mute = Mute::create($request->validated());

        return MuteResource::make($mute);
    }
}
