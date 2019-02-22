<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;

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

    public function resolve($root, $args)
    {
        $object = $this->repository->find($args['id']);

        return ($object->delete());
    }
}
