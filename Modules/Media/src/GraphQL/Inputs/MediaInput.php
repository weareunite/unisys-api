<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class MediaInput extends Input
{
    public function fields()
    : array
    {
        return [
            'name'              => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'custom_properties' => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
        ];
    }
}