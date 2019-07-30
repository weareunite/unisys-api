<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use DB;

abstract class MassDeleteMutation extends Mutation
{
    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'ids' => [
                'name' => 'ids',
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::int()))),
            ],
        ];
    }

    protected function rules(array $args = [])
    {
        return [
            'ids' => [
                'required',
                'array',
            ],
            'ids.*' => [
                'required',
                'numeric',
            ],
        ];
    }

    protected function beforeDelete(Model $model, $root, $args)
    {

    }

    protected function afterDelete(Model $model, $root, $args)
    {

    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            foreach ($args['ids'] as $id) {
                /** @var Model $object */
                $object = $this->repository->find($id);

                $this->beforeDelete($object, $root, $args);

                $object->delete();

                $this->afterDelete($object, $root, $args);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
