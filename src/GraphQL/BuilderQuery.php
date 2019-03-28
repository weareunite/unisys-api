<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL;
use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Rebing\GraphQL\Support\SelectFields;

abstract class BuilderQuery extends Query
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
        return GraphQL::paginate($this->nameOfType());
    }

    public function args()
    {
        return [
            'paging' => [
                'type' => GraphQL::type('PaginationInput')
            ],
            'filter' => [
                'type' => GraphQL::type('QueryFilterInput')
            ],
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $limit = PaginationInput::handleLimit($args);
        $page = PaginationInput::handlePage($args);

//        $typeFields = app($this->typeClass())->fields();
//
//        foreach ($args as $key => $arg) {
//            if(isset($typeFields[$key]['selectable']) && $typeFields[$key]['selectable'] === false) {
//                $query = $query->{camel_case($key)}($arg);
//            }
//        }

        $query = $this->modelClassOfType()::with($with)
            ->select($select);

//        if(isset($args['filter'])) {
//            $query = $query->filter($args['filter'], app($this->typeClass()));
//        }

        return $query->paginate($limit, $select, config('query-filter.page_name'), $page);
    }
}
