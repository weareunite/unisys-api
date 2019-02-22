<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\Mutation;
use Unite\UnisysApi\Modules\Transactions\Contracts\HasTransactions;
use Unite\UnisysApi\Modules\Transactions\Events\MadeTransaction;
use Unite\UnisysApi\Modules\Transactions\GraphQL\TransactionType;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;
use Unite\UnisysApi\Rules\PriceAmount;

abstract class AddTransactionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'addTransaction',
    ];

    public function type()
    {
        return TransactionType::class;
    }

    public function args()
    {
        return [
            'id'                    => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:' . $this->repository->getTable() . ',id',
                ],
            ],
            'type'                  => [
                'type'  => Type::string(),
                'rules' => [
                    'in:' . implode(',', Transaction::getTypes()),
                ],
            ],
            'transaction_source_id' => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:transaction_sources,id',
                ],
            ],
            'destination_iban'      => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|min:15|max:32',
            ],
            'amount'                => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    new PriceAmount,
                ],
            ],
            'variable_symbol'       => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'digits_between:0,10',
                ],
            ],
            'specific_symbol'       => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'digits_between:0,10',
                ],
            ],
            'description'           => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:250',
                ],
            ],
            'posted_at'             => [
                'type'  => Type::string(),
                'rules' => [
                    'date_format:Y-m-d H:i:s',
                ],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        /** @var HasTransactions $object */
        $object = $this->repository->find($args['id']);

        $transaction = $object->addTransaction($args);

        event(new MadeTransaction($transaction));

        return $object;
    }
}
