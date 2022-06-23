<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'discord_username' => 'nullable|regex:/^.{3,32}#[0-9]{4}$/',
            'discord_id' => 'nullable|numeric',
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
        return auth()->check() && (auth()->user()->can('edit all bans') || auth()->id() == $this->responsible_user_id);
    }
}
