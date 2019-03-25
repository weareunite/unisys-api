<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Help\HelpRepository;

class MassDeleteMutation extends BaseMassDeleteMutation
{
    protected $attributes = [
        'name' => 'massDeleteHelp',
    ];

    public function repositoryClass()
    : string
    {
        return HelpRepository::class;
    }
}
