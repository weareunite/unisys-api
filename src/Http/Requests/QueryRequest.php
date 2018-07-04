<?php

namespace Unite\UnisysApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueryRequest extends FormRequest
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
            'limit'     => 'integer|min:1|max:'.config('query-filter.max_limit'),
            'order'     => 'string',
            'search'    => 'json',
            'filter'    => 'json',
        ];
    }
}
