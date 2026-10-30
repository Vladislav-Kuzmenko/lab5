<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'stadium' => ['required', 'string', 'max:100'],
            'founded_year' => ['required', 'integer', 'min:1800', 'max:' . date('Y')],
            'head_coach' => ['required', 'string', 'max:100'],
        ];
    }
}
