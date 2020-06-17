<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Rebing\GraphQL\Support\Mutation;

abstract class CreateMutation extends Mutation
{
    use HasModel;

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
        return GraphQL::type($this->type ?: $this->name);
    }

    public function args()
    : array
    {
        $class = $this->inputClass();
        return (new $class)->fields();
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

        return $this->model->refresh();
    }
}
