<?php

namespace Unite\UnisysApi\Modules\Media\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Unite\UnisysApi\Modules\Media\Models\Media;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Media $this ->resource */
        return [
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'name'              => $this->name,
            'file_name'         => $this->file_name,
            'mime_type'         => $this->mime_type,
            'size'              => $this->size,
            'custom_properties' => $this->custom_properties,
            'created_at'        => (string)$this->created_at,
            'link'              => route('api.media.stream', [ 'model' => $this->id ]),
            'downloadLink'      => route('api.media.download', [ 'model' => $this->id ]),
        ];
    }
}