<?php

namespace Unite\UnisysApi\Http\Resources;

use Unite\UnisysApi\Models\Setting;

class SettingResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Setting $this->resource */
        return [
            'key'   => $this->key,
            'value' => $this->value,
            'type'  => $this->type,
        ];
    }
}

