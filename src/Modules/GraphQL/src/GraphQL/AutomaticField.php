<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Unite\UnisysApi\Http\Controllers\HasModel;

trait AutomaticField
{
    use HasModel;

    /** @var bool */
    protected $pluralizedName = false;

    /** @var string */
    protected $name;

    /** @var Builder */
    protected $query;

    /** @var Model */
    protected $model;

    public function __construct()
    {
        if (!$this->name) {
            $this->name = $this->generateName();
        }
    }

    private function generateName()
    : string
    {
        $basename = class_basename($this->modelClass());

        if ($this->pluralizedName) {
            $name = Str::pluralStudly($basename);
        } else {
            $name = Str::camel($basename);
        }

        return ucfirst($name);
    }
}
