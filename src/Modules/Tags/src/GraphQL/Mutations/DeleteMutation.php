<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as Mutation;
use Unite\UnisysApi\Modules\Tags\TagRepository;

class DeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTag',
    ];

    public function repositoryClass()
    : string
    {
        return TagRepository::class;
    }
}
