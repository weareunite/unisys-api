<?php

namespace Unite\UnisysApi\Modules\Media\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

class Media extends MediaModel
{
    public function getLink()
    {
        return route('api.media.stream', ['model' => $this->id]);
    }

    public function getDownloadLink()
    {
        return route('api.media.download', ['model' => $this->id]);
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