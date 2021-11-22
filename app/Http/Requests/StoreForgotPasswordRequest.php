<?php

namespace App\Http\Requests;

class StoreForgotPasswordRequest extends ParentRequest
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
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
        ];
    }
}
