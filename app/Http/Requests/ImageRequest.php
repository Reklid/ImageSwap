<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'images' => ['required', 'array'],
			'images.*' => ['required', 'image', 'mimes:jpg,png,gif,svg']
        ];
    }
}
