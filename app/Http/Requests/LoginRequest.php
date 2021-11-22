<?php

namespace App\Http\Requests;

class LoginRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_or_phone' => 'required|string',
            'password' => 'required'
        ];
    }
}
