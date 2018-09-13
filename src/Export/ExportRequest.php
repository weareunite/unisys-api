<?php

namespace Unite\UnisysApi\Export;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'order'     => 'string',
            'search'    => 'string',
            'filter'    => 'string',
            'columns'   => 'string',
        ];
    }
}
