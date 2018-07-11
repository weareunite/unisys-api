<?php

namespace Unite\UnisysApi\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Unite\UnisysApi\Models\Setting;

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
            'key'   => 'required|string|max:100|unique:settings',
            'value' => 'nullable',
            'type'  => 'nullable|in:'.implode(',', Setting::getTypes()),
        ];
    }
}
