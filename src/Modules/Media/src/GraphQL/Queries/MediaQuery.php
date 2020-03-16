<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Queries;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\Modules\Contacts\GraphQL\CountryType;

abstract class MediaQuery extends Query
{
    protected $attributes = [
        'name' => 'media',
    ];

    public function type()
    {
        return GraphQL::pagination(GraphQL::type(CountryType::class));
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
                ]
            ],
            'file' => [
                'type' => Type::string(),
                'rules' => 'required|mimes:pdf,jpeg,jpg,png,xsl,xslx,doc,docx'
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $object = $this->repository->find($args['id']);

        $media = $object->getMedia();

        $mediaItem = $object->getMedia()->last();
    }
}
