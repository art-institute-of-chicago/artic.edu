<?php

namespace App\Http\Requests\API;

use App\Rules\NoMarkup;
use Illuminate\Foundation\Http\FormRequest;

class MyMuseumTourRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * Only the artwork IDs and notes are accepted for each artwork. The rest of
     * the artwork details are reloaded from the API when the tour is saved.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'creatorEmail' => 'required|email',
            'marketingOptIn' => 'boolean',
            'tourJson.title' => ['required', 'string', new NoMarkup()],
            'tourJson.description' => ['nullable', 'string', new NoMarkup()],
            'tourJson.creatorName' => ['nullable', 'string', new NoMarkup()],
            'tourJson.recipientName' => ['nullable', 'string', new NoMarkup()],
            'tourJson.artworks' => 'required|array|min:1|max:6',
            'tourJson.artworks.*.id' => 'required|integer|distinct',
            'tourJson.artworks.*.objectNote' => ['nullable', 'string', new NoMarkup()],
        ];
    }
}
