<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reddit_username' => 'required',
            'discord_username' => 'nullable|regex:/^.{3,32}#[0-9]{4}$/',
            'discord_id' => 'nullable|numeric|size:18',
            'aliases' => 'nullable',
            'start_at' => 'required|date',
            'end_at' => 'nullable|required_without:permanent|date|after:start_at',
            'platforms' => 'required',
            'summary' => 'required',
            'comments' => 'nullable',
            'evidence' => 'nullable|url',
            'responsible_user_id' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create bans');
    }
}
