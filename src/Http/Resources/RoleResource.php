<?php

namespace Unite\UnisysApi\Http\Resources;

use Unite\UnisysApi\Models\Role;

class RoleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Models\Role $this->resource */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
        ];
    }

    public static function modelClass()
    {
        return Role::class;
    }
}
