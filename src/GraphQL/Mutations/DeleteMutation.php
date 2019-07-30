<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use DB;

abstract class DeleteMutation extends Mutation
{
    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:'.$this->repository->getTable().',id',
                ]
            ],
        ];
    }

    protected function beforeDelete(Model $model, $root, $args)
    {
        return $model;
    }

    protected function afterDelete(Model $model, $root, $args)
    {

    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            /** @var Model $object */
            $object = $this->repository->find($args['id']);

            $this->beforeDelete($object, $root, $args);

            $object->delete();

            $this->afterDelete($object, $root, $args);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
