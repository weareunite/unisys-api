<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\Mutation;
use Unite\UnisysApi\Modules\Tags\Contracts\HasTags;

abstract class AttachTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'attachTag',
    ];

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id'   => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:'.$this->repository->getTable().',id',
                ],
            ],
            'ids.*'   => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:'.$this->repository->getTable().',id',
                ],
            ],
            'tag_names.*' => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'string',
                ],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if(isset($args['ids'])) {
            foreach ($args['ids'] as $model_id) {
                /** @var HasTags $object */
                $object = $this->repository->find($model_id);
                $object->attachTags($args['tag_names']);
            }
        } else {
            /** @var HasTags $object */
            $object = $this->repository->find($args['id']);
            $object->attachTags($args['tag_names']);
        }

        return true;
    }
}
