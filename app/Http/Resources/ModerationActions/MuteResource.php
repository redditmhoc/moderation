<?php

namespace App\Http\Resources\ModerationActions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ModerationActions\Mute */
class MuteResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reddit_username' => $this->reddit_username,
            'discord_username' => $this->discord_username,
            'discord_id' => $this->discord_id,
            'aliases' => $this->aliases,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'summary' => $this->summary,
            'comments' => $this->comments,
            'evidence' => $this->evidence,
            'platforms' => $this->platforms,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'activities_count' => $this->activities_count,
            'days_remaining' => $this->days_remaining,
            'duration_in_days' => $this->duration_in_days,
            'hours_remaining' => $this->hours_remaining,
            'is_current' => $this->is_current,
            'image_attachments' => $this->imageAttachments->makeHidden(['attachable_id', 'attachable_type', 'created_at', 'updated_at', 'user_id']),
            'duration_in_hours' => $this->duration_in_hours,
            'moderator_responsible' => $this->responsibleUser->only(['id', 'username']),
        ];
    }
}
