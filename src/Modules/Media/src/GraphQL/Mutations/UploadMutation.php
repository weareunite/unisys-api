<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Spatie\MediaLibrary\HasMedia;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\AutomaticField;
use Unite\UnisysApi\Modules\Media\Models\Media;
use Rebing\GraphQL\Support\Mutation;

abstract class UploadMutation extends Mutation
{
    use AutomaticField;

    protected function modelClass()
    : string
    {
        return Media::class;
    }

    public function args()
    : array
    {
        return [
            'id'   => [
                'name'  => 'id',
                'type'  => Type::id(),
                'rules' => [
                    'required',
                    'numeric',
                ],
            ],
            'file' => [
                'type'  => GraphQL::type('Upload'),
                'rules' => 'required|mimes:pdf,jpeg,jpg,png,xsl,xslx,doc,docx',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var HasMedia $object */
        $object = $this->newQuery()->findOrFail($args['id']);

        $media = $object->addMedia($args['file'])
            ->withCustomProperties([])
            ->toMediaCollection('default');

        return $media;
    }
}
