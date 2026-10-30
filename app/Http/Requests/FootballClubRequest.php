<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FootballClubRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:50'],
            'founded_year' => ['required', 'integer', 'min:1800', 'max:' . date('Y')],
            'stadium' => ['required', 'string', 'max:100'],
            'points' => ['required', 'integer', 'min:0'],
        ];
    }
}
