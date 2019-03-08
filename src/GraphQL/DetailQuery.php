<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\SelectFields;

abstract class DetailQuery extends Query
{
    abstract protected function typeClass(): string;

    private function nameOfType()
    {
        return app($this->typeClass())->name;
    }

    private function modelClassOfType()
    {
        return app($this->typeClass())->model;
    }

    public function type()
    {
        return GraphQL::type($this->nameOfType());
    }

    public function args()
    {
        return [
            'id'    => [
                'type' => Type::int(),
            ],
        ];
    }

    protected function beforeResolve($root, $args, $select, $with)
    {
        return $args;
    }

    protected function afterResolve($root, $args, $select, $with, $object)
    {

    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $args = $this->beforeResolve($root, $args, $select, $with);

        $object = $this->modelClassOfType()::with($with)
            ->select($select)
            ->where('id', '=', $args['id'])
            ->first();

        $this->afterResolve($root, $args, $select, $with, $object);

        return $object;
    }
}
