<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:2'],
            'name' => ['required', 'string', 'max:52'],
            'population' => ['required', 'integer', 'min:0'],
        ];
    }
}
