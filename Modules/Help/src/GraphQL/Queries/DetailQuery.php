<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Queries;

use Rebing\GraphQL\Support\SelectFields;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\DetailQuery as BaseDetailQuery;
use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\Help\Help;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return Help::class;
    }

    public function args()
    : array
    {
        return array_merge(parent::args(), [
            'key' => [
                'type' => Type::string(),
            ],
        ]);
    }

    protected function find(array $args, SelectFields $fields)
    {
        if (isset($args['id'])) {
            $column = 'id';
            $value = $args['id'];
        } elseif (isset($args['key'])) {
            $column = 'key';
            $value = $args['key'];
        } else {
            throw new \Exception('Id o Key must be defined for find help record');
        }

        $this->model = $this->newQuery()->with($fields->getRelations())
            ->addSelect($fields->getSelect())
            ->where($column, '=', $value)
            ->where('id', '=', $args['id'])
            ->firstOrFail();
    }
}
