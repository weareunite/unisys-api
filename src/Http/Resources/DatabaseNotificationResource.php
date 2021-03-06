<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Notifications\DatabaseNotification;

class DatabaseNotificationResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Illuminate\Notifications\DatabaseNotification $this->resource */
        return [
            'id'                => $this->id,
            'type'              => class_basename($this->type),
            'data'              => $this->data,
            'read_at'           => (String)$this->read_at,
            'created_at'        => (String)$this->created_at,
        ];
    }

    public static function modelClass()
    {
        return DatabaseNotification::class;
    }
}
