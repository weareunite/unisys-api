<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;

abstract class DeleteMutation extends Mutation
{
    use AutomaticField;

    public function attributes()
    : array
    {
        return [
            'name' => 'delete' . $this->name,
        ];
    }

    public function type()
    : Type
    {
        return Type::boolean();
    }

    public function args()
    : array
    {
        return [
            'id' => [
                'name'  => 'id',
                'type'  => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:' . $this->repository->getTable() . ',id',
                ],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $object = $this->newQuery()->findOrFail($args['id']);

        $object->delete();

        return true;
    }
}
