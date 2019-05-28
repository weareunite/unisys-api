<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Resources;

use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Http\Resources\Resource;

class CountryResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Country $this->resource */
        return [
            'id'                => $this->id,
            'capital'           => $this->capital,
            'citizenship'       => $this->citizenship,
            'country_code'      => $this->country_code,
            'currency'          => $this->currency,
            'currency_code'     => $this->currency_code,
            'currency_sub_unit' => $this->currency_sub_unit,
            'currency_symbol'   => $this->currency_symbol,
            'currency_decimals' => $this->currency_decimals,
            'full_name'         => $this->full_name,
            'iso_3166_2'        => $this->iso_3166_2,
            'iso_3166_3'        => $this->iso_3166_3,
            'name'              => $this->name,
            'region_code'       => $this->region_code,
            'sub_region_code'   => $this->sub_region_code,
            'eea'               => $this->eea,
            'calling_code'      => $this->calling_code,
            'flag'              => $this->flag,
        ];
    }

    public static function modelClass()
    {
        return Country::class;
    }
}