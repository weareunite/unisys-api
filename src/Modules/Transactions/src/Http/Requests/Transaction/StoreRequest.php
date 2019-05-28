<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;
use Unite\UnisysApi\Rules\PriceAmount;

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

    protected function prepareForValidation()
    {
        if ($this->has('destination_iban')) {
            $destination_iban = $this->get('destination_iban');

            if ($destination_iban === '') {
                $destination_iban = null;
            }

            $this->merge([
                'destination_iban' => $destination_iban
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'                  => 'in:' . implode(',', Transaction::getTypes()),
            'transaction_source_id' => 'required|integer|exists:transaction_sources,id',
            'destination_iban'      => 'nullable|string|min:15|max:32',
            'amount'                => [ 'required', new PriceAmount ],
            'variable_symbol'       => 'nullable|digits_between:0,10',
            'specific_symbol'       => 'nullable|digits_between:0,10',
            'description'           => 'nullable|string|max:250',
            'posted_at'             => 'date_format:Y-m-d H:i:s',
        ];

    }
}
