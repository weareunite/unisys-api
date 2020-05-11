<?php

namespace Unite\UnisysApi\Modules\Permissions\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Unite\UnisysApi\Modules\Permissions\Role;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Role $this ->resource */
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'guard_name' => $this->guard_name,
        ];
    }
}
