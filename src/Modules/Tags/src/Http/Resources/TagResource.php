<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Unite\UnisysApi\Modules\Tags\Tag;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Tag $this */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'type'              => $this->type,
            'created_at'        => (string)$this->created_at,
        ];
    }
}
