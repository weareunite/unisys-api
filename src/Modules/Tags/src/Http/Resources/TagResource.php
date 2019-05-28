<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Resources;

use Unite\UnisysApi\Modules\Tags\Tag;
use Unite\UnisysApi\Http\Resources\Resource;

class TagResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Modules\Tags\Tag $this->resource */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'type'              => $this->type,
            'custom_properties' => $this->custom_properties,
            'created_at'        => (string) $this->created_at,
        ];
    }

    public static function modelClass()
    {
        return Tag::class;
    }
}
