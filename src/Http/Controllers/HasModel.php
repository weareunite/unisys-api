<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasModel
{
    /** @var Model */
    protected $model;

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var bool */
    protected $pluralizedName = false;

    public function __construct()
    {
        if (!$this->name) {
            $this->name = $this->generateName();
        }

        if (!$this->type) {
            $this->type = $this->generateType();
        }
    }

    abstract protected function modelClass()
    : string;

    /**
     * @return Builder
     */
    protected function newQuery()
    {
        return app($this->modelClass())->newModelQuery();
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

    private function generateType()
    : string
    {
        $basename = class_basename($this->modelClass());

        return Str::studly($basename);
    }
}