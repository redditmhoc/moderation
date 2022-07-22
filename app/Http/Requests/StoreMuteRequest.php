<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMuteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reddit_username' => 'required',
            'discord_username' => 'nullable|regex:/^.{3,32}#[0-9]{4}$/',
            'discord_id' => 'nullable|numeric',
            'aliases' => 'nullable',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'platforms' => 'required',
            'summary' => 'required',
            'comments' => 'nullable',
            'evidence' => 'nullable|url',
            'responsible_user_id' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create mutes');
    }
}
