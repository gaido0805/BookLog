<?php

namespace App\Interfaces\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'read_date' => 'required|date',
            'impression' => 'required|string',
        ];
    }
}
