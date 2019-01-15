<?php

namespace Unite\UnisysApi\Http\Resources;

use Unite\UnisysApi\Models\Permission;

class PermissionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Models\Permission $this->resource */
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'guard_name' => $this->guard_name,
        ];
    }

    public static function modelClass()
    {
        return Permission::class;
    }
}
