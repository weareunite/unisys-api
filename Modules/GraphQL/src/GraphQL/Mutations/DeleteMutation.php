<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use Exception;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Http\Controllers\HasModel;

abstract class DeleteMutation extends Mutation
{
    use HasModel;

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
                ],
            ],
        ];
    }

    /**
     * @param array $args
     * @throws Exception
     */
    protected function delete(array $args)
    {
        $this->model->delete();
    }

    /**
     * @param $root
     * @param $args
     * @return bool
     * @throws Exception
     */
    public function resolve($root, $args)
    {
        $this->model = $this->newQuery()->findOrFail($args['id']);

        $this->delete($args);

        return true;
    }
}
