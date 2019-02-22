<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;

class TransactionType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Transaction',
        'description' => 'A transaction',
        'model'       => Transaction::class,
    ];

    public function fields()
    {
        return [
            'id'                 => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of contact',
            ],
            'type'               => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'subject_type'       => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'subject_id'         => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'amount'             => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'balance'            => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'variable_symbol'    => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'specific_symbol'    => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'description'        => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'posted_at'          => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'created_at'         => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'destination_iban'   => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'transaction_source' => [
                'type'        => Type::listOf(GraphQL::type('Source')),
                'description' => 'The type of contact',
            ],
        ];
    }
}
