<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

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
        /** @var \Spatie\MediaLibrary\Models\Media $this->resource */
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'file_name'         => $this->file_name,
            'mime_type'         => $this->mime_type,
            'size'              => $this->size,
            'custom_properties' => $this->custom_properties,
            'created_at'        => (string)$this->created_at,
            'link'              => route('api.media.stream', ['id' => $this->id]),
            'downloadLink'      => route('api.media.download', ['id' => $this->id]),
            'unprotectedLink'   => route('web.unprotectedMedia.stream', ['id' => $this->id]),
        ];
    }
}
