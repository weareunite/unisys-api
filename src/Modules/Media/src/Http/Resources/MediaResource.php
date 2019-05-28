<?php

namespace Unite\UnisysApi\Modules\Media\Http\Resources;

use Unite\UnisysApi\Http\Resources\Resource;
use Unite\UnisysApi\Modules\Media\Models\Media;

class MediaResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Media $this->resource */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'file_name'         => $this->file_name,
            'mime_type'         => $this->mime_type,
            'size'              => $this->size,
            'custom_properties' => $this->custom_properties,
            'created_at'        => (string)$this->created_at,
            'link'              => $this->getLink(),
            'downloadLink'      => $this->getDownloadLink(),
        ];
    }

    public static function modelClass()
    {
        return Media::class;
    }
}