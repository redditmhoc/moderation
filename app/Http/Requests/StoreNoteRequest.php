<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reddit_username' => 'required',
            'discord_username' => 'nullable|regex:/^.{3,32}#[0-9]{4}$/',
            'discord_id' => 'nullable|numeric',
            'responsible_user_id' => 'required',
            'content' => 'required'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create notes');
    }
}
