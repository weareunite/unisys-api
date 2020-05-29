<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Http\Controllers\HasModel;

abstract class UpdateMutation extends Mutation
{
    use HasModel;

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
        $class = $this->inputClass();
        return array_merge([
            'id' => [
                'type'  => Type::nonNull(Type::int()),
                'rules' => [
                    'required',
                    'numeric',
                ],
            ],
        ], (new $class)->update()->fields());
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

            unset($args['id']);

            $this->update($args);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
