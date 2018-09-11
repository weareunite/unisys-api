<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @property float|null $amount
 */
abstract class Model extends BaseModel
{
    protected $resourceEagerLoads = [];

    protected $resourceTableMap = [];

    public function getResourceEagerLoads(): array
    {
        return $this->resourceEagerLoads;
    }

    public function getResourceTableMap(): array
    {
        return $this->resourceTableMap;
    }
}
