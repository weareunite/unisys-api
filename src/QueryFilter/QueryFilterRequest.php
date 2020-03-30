<?php

namespace Unite\UnisysApi\QueryFilter;

use Illuminate\Foundation\Http\FormRequest;

class QueryFilterRequest extends FormRequest
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
            'page'      => 'integer|min:1',
            'limit'     => 'integer|min:1|max:'.config('unisys.query-filter.max_limit'),
            'order'     => 'string',
            'search'    => 'string',
            'filter'    => 'string',
        ];
    }
}
