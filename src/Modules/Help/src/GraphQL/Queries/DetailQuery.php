<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Queries;

use Rebing\GraphQL\Support\SelectFields;
use Unite\UnisysApi\GraphQL\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Help\GraphQL\HelpType;
use GraphQL\Type\Definition\Type;

class DetailQuery extends BaseDetailQuery
{
    protected $attributes = [
        'name' => 'help',
    ];

    protected function typeClass()
    : string
    {
        return HelpType::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'key' => [
                'type' => Type::string(),
            ],
        ]);
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $args = $this->beforeResolve($root, $args, $select, $with);

        $column = 'id';
        $value = $args['id'];

        if(isset($args['key'])) {
            $column = 'key';
            $value = $args['key'];
        }

        $object = $this->modelClassOfType()::with($with)
            ->select($select)
            ->where($column, '=', $value)
            ->first();

        $this->afterResolve($root, $args, $select, $with, $object);

        return $object;
    }
}
