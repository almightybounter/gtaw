<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for your note.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'content.required' => 'Please provide content for your note.',
            'content.max' => 'The content cannot exceed 10,000 characters.',
        ];
    }
} 