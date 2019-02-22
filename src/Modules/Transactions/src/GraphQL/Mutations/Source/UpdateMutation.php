<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations\Source;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Transactions\Models\Source;
use Unite\UnisysApi\Modules\Transactions\SourceRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateSource',
    ];

    public function repositoryClass()
    : string
    {
        return SourceRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'type'                  => [
                'type'  => Type::string(),
                'rules' => 'in:'.implode(',', Source::getTypes()),
            ],
            'name'                  => [
                'type'  => Type::string(),
                'rules' => 'string|max:100',
            ],
            'short_name'                  => [
                'type'  => Type::string(),
                'rules' => 'string|max:10',
            ],
            'iban'               => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|min:15|max:32',
            ],
            'bic'                 => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|min:8|max:11',
            ],
            'swift'              => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|min:8|max:11',
            ],
            'description'              => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|max:250',
            ],
        ]);
    }
}
