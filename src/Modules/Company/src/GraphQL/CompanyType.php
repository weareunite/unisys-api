<?php

namespace Unite\UnisysApi\Modules\Company\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Company\Company;

class CompanyType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Company',
        'description' => 'A Company',
        'model'       => Company::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'              => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'name'            => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'is_active'       => [
                'type'        => Type::boolean(),
                'description' => 'If resource is active or not',
            ],
            'contact_profile' => [
                'type' => GraphQL::type('ContactProfile'),
            ],
        ];
    }
}

