<?php

namespace Unite\UnisysApi\Modules\Export\Http;

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
            'filter'                       => 'nullable|array',
            'filter.id'                    => 'nullable|numeric',
            'filter.order'                 => 'nullable|string',
            'filter.search.query'          => 'nullable|string',
            'filter.search.fields'         => 'nullable|array',
            'filter.search.fields.*'       => 'nullable|string',
            'filter.conditions'            => 'nullable|array',
            'filter.conditions.*.field'    => 'nullable|string',
            'filter.conditions.*.operator' => 'nullable|string',
            'filter.conditions.*.values'   => 'nullable|array',
            'filter.conditions.*.values.*' => 'nullable|string',
            'keys'                         => 'required|array',
            'keys.*.key'                   => 'required|string',
            'keys.*.name'                  => 'required|string',
        ];
    }
}
