<?php

namespace Unite\UnisysApi\Rules;

use Illuminate\Contracts\Validation\Rule;

class PriceAmount implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ( preg_match('/^\d{1,10}(\.\d{1,2})??$/', $value) );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be correct price';
    }

    public function __toString()
    {
        return 'PriceAmount';
    }
}
