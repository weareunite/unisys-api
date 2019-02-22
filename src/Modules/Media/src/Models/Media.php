<?php

namespace Unite\UnisysApi\Modules\Media\Models;

use Spatie\MediaLibrary\Models\Media as Model;

class Media extends Model
{
    public function getLink()
    {
        return route('api.media.stream', ['id' => $this->id]);
    }

    protected function getDownloadLink()
    {
        return route('api.media.download', ['id' => $this->id]);
    }

    public function getLinkAttribute()
    {
        return $this->getLink();
    }

    protected function getDownloadLinkAttribute()
    {
        return $this->getDownloadLink();
    }
}