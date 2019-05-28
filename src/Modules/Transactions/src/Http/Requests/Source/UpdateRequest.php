<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;
use Unite\UnisysApi\Modules\Transactions\Models\Source;

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
            'type'          => 'in:'.implode(',', Source::getTypes()),
            'name'          => 'string|max:100',
            'short_name'    => 'string|max:10',
            'iban'          => 'nullable|string|min:15|max:32',
            'bic'           => 'nullable|string|min:8|max:11',
            'swift'         => 'nullable|string|min:8|max:11',
            'description'   => 'nullable|string|max:250',
        ];
    }
}
