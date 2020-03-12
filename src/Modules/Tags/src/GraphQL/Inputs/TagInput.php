<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class TagInput extends Input
{
    public function fields()
    : array
    {
        return [
            'name'     => [
                'type' => Type::string(),
                'rules'=> 'required|string',
            ],
            'type'  => [
                'type' => Type::string(),
                'rules'=> 'nullable|array',

            ],
        ];
    }
}