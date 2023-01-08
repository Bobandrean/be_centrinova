<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "judul" => "required",
            "short_content" => "required",
            "image" => "required|file|mimes:jpg,jpeg,png,gif"
        ];
    }

    public function messages()
    {
        $message =  [
            'judul.required' => 'Judul required',
            'short_content.required' => 'Short Content required',
            "image.required.file.mimes:jpg,jpeg,png,gif" => 'Image Required'
        ];


        return $message;
    }
}
