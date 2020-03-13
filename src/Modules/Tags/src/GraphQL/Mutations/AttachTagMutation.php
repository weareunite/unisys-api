<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Tags\Contracts\HasTags;

abstract class AttachTagMutation extends Mutation
{
    use HasModel;

    public function attributes(): array
    {
        return [
            'name' => 'attach' . $this->name,
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
            'id'          => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
                ],
            ],
            'ids.*'       => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'integer',
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
        if (isset($args['ids'])) {
            /** @var HasTags[] $models */
            $models = $this->newQuery()->whereIn('id', $args['ids']);
            foreach ($models as $model) {
                $model->attachTags($args['tag_names']);
            }
        } else {
            /** @var HasTags $object */
            $object = $this->newQuery()->findOrFail($args['id']);
            $object->attachTags($args['tag_names']);
        }

        return true;
    }
}
