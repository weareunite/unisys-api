<?php

namespace Unite\UnisysApi\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'                  => 'required|string|min:3|max:100',
            'email'                 => 'email|unique:users',
            'username'              => 'required|regex:/^\S*$/u|min:4|max:20|unique:users',
            'password'              => 'required|confirmed|string|min:6|max:30',
            'password_confirmation' => 'required|string|min:6|max:30',
            'roles'                 => 'required|array',
        ];
    }
}
