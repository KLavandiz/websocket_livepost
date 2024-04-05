<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required',
            'body' => 'string|required',
            'user_ids' => [
                'array',
                'required',
                new IntegerArray(),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Please enter a valid body',
            'title.required' => 'Please enter a valid title',
        ];
    }
}
