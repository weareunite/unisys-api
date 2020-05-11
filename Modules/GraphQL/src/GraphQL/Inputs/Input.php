<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs;

use Illuminate\Support\Str;
use Rebing\GraphQL\Support\InputType;

abstract class Input extends InputType
{
    protected $inputObject = true;

    protected $isUpdate = false;

    public function attributes()
    : array
    {
        return [
            'name' => ucfirst(Str::camel(class_basename($this))),
        ];
    }

    public function update()
    {
        $this->isUpdate = true;

        return $this;
    }
}