<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;

abstract class MassDeleteMutation extends Mutation
{
    use AutomaticField;

    public function attributes()
    : array
    {
        return [
            'name' => 'massDelete' . $this->name,
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
            'ids' => [
                'name' => 'ids',
                'type' => Type::nonNull(Type::listOf(Type::nonNull(Type::int()))),
            ],
        ];
    }

    protected function rules(array $args = [])
    : array
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'required',
                'numeric',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            $this->newQuery()->whereIn('id', $args['ids'])->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }
}
