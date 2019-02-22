<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Transactions\Models\Source;

class SourceType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Source',
        'description' => 'A source',
        'model'       => Source::class,
    ];

    public function fields()
    {
        return [
            'id'              => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of source',
            ],
            'type'            => [
                'type'        => Type::string(),
                'description' => 'The type of source',
            ],
            'balance'         => [
                'type'        => Type::string(),
                'description' => 'The balance of source',
            ],
            'is_bank_account' => [
                'type'        => Type::boolean(),
                'description' => 'The is_bank_account of source',
                'selectable'  => false,
            ],
            'name'            => [
                'type'        => Type::string(),
                'description' => 'The name of source',
            ],
            'short_name'      => [
                'type'        => Type::string(),
                'description' => 'The short_name of source',
            ],
            'iban'            => [
                'type'        => Type::string(),
                'description' => 'The iban of source',
            ],
            'bic'             => [
                'type'        => Type::string(),
                'description' => 'The bic of source',
            ],
            'swift'           => [
                'type'        => Type::string(),
                'description' => 'The swift of source',
            ],
            'description'     => [
                'type'        => Type::string(),
                'description' => 'The description of source',
            ],
            'created_at'      => [
                'type'        => Type::string(),
                'description' => 'The created_at of source',
            ],
        ];
    }
}

