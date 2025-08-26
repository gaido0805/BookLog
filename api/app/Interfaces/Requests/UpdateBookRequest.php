<?php

namespace App\Interfaces\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'read_date' => 'sometimes|required|date',
            'impression' => 'sometimes|required|string',
        ];
    }
}
