<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;
use Rebing\GraphQL\Support\Mutation;

abstract class CreateMutation extends Mutation
{
    use AutomaticField;

    abstract protected function inputClass()
    : string;

    public function attributes(): array
    {
        return [
            'name' => 'create' . $this->name,
        ];
    }

    public function type(): Type
    {
        return GraphQL::type($this->name);
    }

    protected function create(array $data)
    {
        $this->model = $this->newQuery()->create($data);
    }

    public function resolve($root, $args)
    {
        $this->create($args);

        return $this->model;
    }
}
