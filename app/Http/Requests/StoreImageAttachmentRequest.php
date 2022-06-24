<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageAttachmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => 'required|url',
            'attachable_type' => 'required',
            'attachable_id' => 'required|uuid'
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create image attachments');
    }
}
