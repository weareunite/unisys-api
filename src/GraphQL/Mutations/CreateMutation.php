<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use Unite\UnisysApi\Models\Model;

abstract class CreateMutation extends Mutation
{
    protected function beforeCreate($root, $args)
    {

    }

    protected function afterCreate(Model $model, $root, $args)
    {

    }

    public function resolve($root, $args)
    {
        $this->beforeCreate($root, $args);

        $object = $this->repository->create($args);

        $this->afterCreate($object, $root, $args);

        return $object;
    }
}
