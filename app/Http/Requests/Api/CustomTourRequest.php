<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CustomTourRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'artworks' => 'required|array',
            'artworks.*.id' => 'required|integer',
            'artworks.*.title' => 'required|string',
            'artworks.*.objectNote' => 'nullable|string',
        ];
    }
}
