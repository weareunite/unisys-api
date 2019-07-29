<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use DB;
use Illuminate\Database\Eloquent\Model;

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
        DB::beginTransaction();

        try {
            $this->beforeCreate($root, $args);

            $object = $this->repository->create($args);

            $this->afterCreate($object, $root, $args);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return $object;
    }
}
