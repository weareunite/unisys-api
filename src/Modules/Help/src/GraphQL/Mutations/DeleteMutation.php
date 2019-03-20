<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Help\HelpRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteHelp',
    ];

    public function repositoryClass()
    : string
    {
        return HelpRepository::class;
    }
}
