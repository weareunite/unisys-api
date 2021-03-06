<?php

namespace Unite\UnisysApi\Http\Resources;

use Unite\UnisysApi\Models\User;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Models\User $this->resource */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'surname'           => $this->surname,
            'email'             => $this->email,
            'username'          => $this->username,
            'roles'             => RoleResource::collection($this->roles()->get(['id', 'name']))
        ];
    }

    public static function modelClass()
    {
        return User::class;
    }

    public static function resourceMap()
    {
        $map = [
            'roles' => RoleResource::class
        ];

        return parent::resourceMap()->merge($map);
    }
}
