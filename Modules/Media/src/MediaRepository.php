<?php

namespace Unite\UnisysApi\Modules\Media;

use Unite\UnisysApi\Modules\Media\Models\Media;
use Unite\UnisysApi\Repositories\Repository;

class MediaRepository extends Repository
{
    protected $modelClass = Media::class;
}