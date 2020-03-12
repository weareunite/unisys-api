<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class SettingInput extends Input
{
    public function fields()
    : array
    {
        return [
            'key'   => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:100',
            ],
            'value' => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable|string',
                ],
            ],
        ];
    }
}