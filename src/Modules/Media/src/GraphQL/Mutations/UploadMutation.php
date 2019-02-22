<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Media\MediaType;
use Unite\UnisysApi\GraphQL\Mutations\Mutation;
use Rebing\GraphQL\Support\UploadType;
use Unite\UnisysApi\Modules\Media\Services\UploadService;

abstract class UploadMutation extends Mutation
{
    public function type()
    {
        return MediaType::class;
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::id(),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:'.$this->repository->getTable().',id',
                ]
            ],
            'file' => [
                'type' => UploadType::getInstance(),
                'rules' => 'required|mimes:pdf,jpeg,jpg,png,xsl,xslx,doc,docx'
            ],
        ];
    }

    public function resolve($root, $args, UploadService $uploadService)
    {
        $object = $this->repository->find($args['id']);

        return $uploadService->upload($object, $args['file']);
    }
}
