<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use DB;

abstract class UpdateMutation extends Mutation
{
    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:'.$this->repository->getTable().',id',
                ]
            ],
        ];
    }

    protected function beforeUpdate(Model $model, $root, $args)
    {

    }

    protected function afterUpdate(Model $model, $root, $args)
    {

    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            /** @var Model $object */
            $object = $this->repository->find($args['id']);

            $this->beforeUpdate($object, $root, $args);

            $object->update($args);

            $this->afterUpdate($object, $root, $args);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
