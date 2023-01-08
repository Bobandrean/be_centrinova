<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            "email" => "required|email",
            "password" => "required|min:3",
            'no_telepon' => 'required|int',
            'alamat' => 'required'
        ];
    }

    public function messages()
    {
        $message =  [
            'email.required|email' => 'Email required',
            'password.required|min:3' => 'Password required',
            'no_telepon.required|int' => 'No telepon required',
            'alamat.required' => 'Alamat required'
        ];


        return $message;
    }
}
