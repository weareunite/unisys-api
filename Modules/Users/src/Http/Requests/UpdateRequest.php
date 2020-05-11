<?php

namespace Unite\UnisysApi\Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'                  => 'string|min:3|max:100',
            'email'                 => 'email|unique:users,email,' . $this->id,
            'username'              => 'regex:/^\S*$/u|min:4|max:20|unique:users,username,' . $this->id,
            'password'              => 'string|confirmed|min:6|max:30',
            'password_confirmation' => 'required_with:password|string|min:6|max:30',
            'roles'                 => 'required|array',
        ];
    }
}
