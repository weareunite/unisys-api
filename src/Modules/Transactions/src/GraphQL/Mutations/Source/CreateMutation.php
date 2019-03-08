<?php

namespace Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations\Source;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Transactions\Models\Source;
use Unite\UnisysApi\Modules\Transactions\SourceRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createSource',
    ];

    public function repositoryClass()
    : string
    {
        return SourceRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Source');
    }

    public function args()
    {
        return [
            'type'                  => [
                'type'  => Type::string(),
                'rules' => 'required|in:'.implode(',', Source::getTypes()),
            ],
            'name'                  => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:100',
            ],
            'short_name'                  => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:10',
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
        ];
    }
}
