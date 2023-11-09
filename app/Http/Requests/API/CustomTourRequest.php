<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CustomTourRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'creator_email' => 'required|email',
            'marketing_opt_in' => 'boolean',
            'tour_json.title' => 'required|string',
            'tour_json.description' => 'nullable|string',
            'tour_json.creatorName' => 'nullable|string',
            'tour_json.recipientName' => 'nullable|string',
            'tour_json.artworks' => 'required|array',
            'tour_json.artworks.*.id' => 'required|integer',
            'tour_json.artworks.*.imageId' => 'nullable|string',
            'tour_json.artworks.*.description' => 'nullable|string',
            'tour_json.artworks.*.galleryTitle' => 'nullable|string',
            'tour_json.artworks.*.artistTitle' => 'nullable|string',
            'tour_json.artworks.*.dateDisplay' => 'nullable|string',
            'tour_json.artworks.*.title' => 'required|string',
            'tour_json.artworks.*.objectNote' => 'nullable|string',
        ];
    }
}
