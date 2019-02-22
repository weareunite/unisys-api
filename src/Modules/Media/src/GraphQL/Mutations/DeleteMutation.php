<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Media\MediaRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteMedia',
    ];

    public function repositoryClass()
    : string
    {
        return MediaRepository::class;
    }
}
