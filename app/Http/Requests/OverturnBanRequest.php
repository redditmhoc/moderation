<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OverturnBanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reason' => 'required'
        ];
    }

    public function authorize(): bool
    {
        if ($this->ban->permanent) {
            return $this->user()->can('overturnPermanent', $this->ban);
        } else {
            return $this->user()->can('overturn', $this->ban);
        }
    }
}
