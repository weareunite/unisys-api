<?php

namespace Unite\UnisysApi\GraphQL;

trait AdditionalFields
{
    public function fields()
    {
        return array_merge(
            parent::fields(), $this->additionalFields()
        );
    }

    abstract public function additionalFields();
}