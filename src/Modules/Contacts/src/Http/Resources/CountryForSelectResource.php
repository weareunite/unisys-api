<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Unite\UnisysApi\Modules\Contacts\Models\Country;

class CountryForSelectResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Country $this ->resource */
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}