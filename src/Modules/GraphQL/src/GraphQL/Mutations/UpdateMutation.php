<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;

abstract class UpdateMutation extends Mutation
{
    use AutomaticField;

    abstract protected function inputClass()
    : string;

    public function type()
    : Type
    {
        return Type::boolean();
    }

    public function attributes()
    : array
    {
        return [
            'name' => 'update' . $this->name,
        ];
    }

    public function args()
    : array
    {
        return array_merge([
            'id' => [
                'type'  => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric',
                ],
            ],
        ], (new ($this->inputClass()))->fields());
    }

    protected function update(array $args)
    {
        $this->model->update($args);
    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            $this->model = $this->newQuery()->findOrFail($args['id']);

            $this->update($args);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
