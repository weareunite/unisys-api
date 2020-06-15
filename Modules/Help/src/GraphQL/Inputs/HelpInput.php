<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class HelpInput extends Input
{
    public function fields()
    : array
    {
        return [
            'key'  => [
                'type'  => Type::string(),
                'rules' => $this->isUpdate ? 'string|max:250' : 'required|string|max:250|unique:help,key',
            ],
            'name' => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|max:250',
            ],
            'body' => [
                'type'  => Type::string(),
                'rules' => $this->isUpdate ? 'string' : 'required|string',
            ],
        ];
    }
}