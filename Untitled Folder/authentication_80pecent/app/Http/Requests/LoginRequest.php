<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|max:100|min:10|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.max' => 'Email is too long',
            'email.min' => 'Email is too short',
            'email.email' => 'Email invalidate',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Incorrect password or email.',
        ];
    }
}
