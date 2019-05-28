<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class StoreRequest extends FormRequest
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
            'type'              => 'nullable|in:' . implode(',', Contact::getTypes()),
            'name'              => 'nullable|string|max:100',
            'surname'           => 'nullable|string|max:100',
            'company'           => 'required|string|max:100',
            'street'            => 'nullable|string|max:100',
            'zip'               => 'nullable|string|max:40',
            'city'              => 'nullable|string|max:40',
            'country_id'        => 'nullable|integer|exists:countries,id',
            'reg_no'            => 'nullable|string|max:40',
            'tax_no'            => 'nullable|string|max:40',
            'vat_no'            => 'nullable|string|max:40',
            'web'               => 'nullable|string|max:40',
            'email'             => 'nullable|email',
            'telephone'         => 'nullable|string|max:40',
            'description'       => 'nullable|string|max:250',
            'custom_properties' => 'nullable|array',
        ];
    }
}
