<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;
use Rebing\GraphQL\Support\Mutation;

abstract class CreateMutation extends Mutation
{
    use AutomaticField;

    abstract protected function inputClass()
    : string;

    public function attributes()
    : array
    {
        return [
            'name' => 'create' . $this->name,
        ];
    }

    public function type()
    : Type
    {
        return GraphQL::type($this->name);
    }

    public function args()
    : array
    {
        return new ($this->inputClass())->fields();
    }

    protected function create(array $data)
    : Model
    {
        return $this->newQuery()->create($data);
    }

    private function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function resolve($root, $args)
    {
        $this->setModel($this->create($args));

        return $this->model;
    }
}
