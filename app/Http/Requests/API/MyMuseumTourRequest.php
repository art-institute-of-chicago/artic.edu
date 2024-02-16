<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MyMuseumTourRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'creatorEmail' => 'required|email',
            'marketingOptIn' => 'boolean',
            'tourJson.title' => 'required|string',
            'tourJson.description' => 'nullable|string',
            'tourJson.creatorName' => 'nullable|string',
            'tourJson.recipientName' => 'nullable|string',
            'tourJson.artworks' => 'required|array',
            'tourJson.artworks.*.title' => 'required|string',
            'tourJson.artworks.*.id' => 'required|integer',
            'tourJson.artworks.*.image_id' => 'nullable|string',
            'tourJson.artworks.*.description' => 'nullable|string',
            'tourJson.artworks.*.gallery_title' => 'nullable|string',
            'tourJson.artworks.*.gallery_id' => 'nullable|integer',
            'tourJson.artworks.*.artist_title' => 'nullable|string',
            'tourJson.artworks.*.display_date' => 'nullable|string',
            'tourJson.artworks.*.thumbnail.lqip' => 'nullable|string',
            'tourJson.artworks.*.thumbnail.width' => 'nullable|integer',
            'tourJson.artworks.*.thumbnail.height' => 'nullable|integer',
            'tourJson.artworks.*.thumbnail.alt_text' => 'nullable|string',
            'tourJson.artworks.*.objectNote' => 'nullable|string',
        ];
    }
}
