<?php

namespace Unite\UnisysApi\Modules\Users\Http;

use Illuminate\Http\Resources\Json\JsonResource;
use Unite\UnisysApi\Modules\Users\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this ->resource */
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'username'  => $this->username,
            'is_active' => $this->isActive(),
            'roles'     => $this->getRoleNames(),
        ];
    }
}
