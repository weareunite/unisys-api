<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ActivityResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Spatie\Activitylog\Models\Activity $this->resource */
        return [
            'id'                => $this->id,
            'log_name'          => $this->log_name,
            'description'       => $this->description,
            'subject'           => $this->subject,
            'causer'            => $this->causer,
            'properties'        => $this->properties,
            'created_at'        => (string)$this->created_at,
        ];
    }
}
