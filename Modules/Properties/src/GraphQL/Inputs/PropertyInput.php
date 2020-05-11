<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class PropertyInput extends Input
{
    public function fields()
    : array
    {
        return [
            'key'   => [
                'type'        => Type::nonNull(Type::string()),
                'rules'       => 'required|string|max:190',
                'description' => 'The key of property',
            ],
            'value' => [
                'type'        => Type::string(),
                'rules'       => 'nullable|string|max:190',
                'description' => 'The value of property',
            ],
        ];
    }
}