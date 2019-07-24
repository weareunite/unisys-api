<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

interface HasPropertiesContract
{
    public function propertiesField()
    : array;
}