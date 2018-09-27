<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property float|null $amount
 */
abstract class Model extends BaseModel
{
    protected $resourceEagerLoads = [];

    public function getResourceEagerLoads(): array
    {
        return $this->resourceEagerLoads;
    }
}
