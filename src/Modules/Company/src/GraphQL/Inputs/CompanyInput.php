<?php

namespace Unite\UnisysApi\Modules\Company\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class CompanyInput extends Input
{
    public function fields()
    : array
    {
        return [
            'name'            => [
                'type'  => Type::string(),
                'rules' => 'string|max:150',
            ],
            'contact_profile' => [
                'type' => GraphQL::type('ContactProfileInput'),
            ],
        ];
    }
}