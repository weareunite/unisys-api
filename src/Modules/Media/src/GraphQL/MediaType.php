<?php

namespace Unite\UnisysApi\GraphQL\Media;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Media\Models\Media;

class MediaType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Media',
        'description' => 'A media',
        'model'       => Media::class,
    ];

    public function fields()
    {
        return [
            'id'                => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the media',
            ],
            'name'              => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of media',
            ],
            'file_name'         => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The file_name of media',
            ],
            'mime_type'         => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The mime_type of media',
            ],
            'size'              => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The size of media',
            ],
            'custom_properties' => [
                'type'        => Type::string(),
                'description' => 'The custom_properties of media',
            ],
            'created_at'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The created_at of media',
            ],
            'link'              => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The link of media',
                'selectable'  => false,
                'filterable'  => false,
                'sortable'    => false,
            ],
            'download_link'     => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The download link of media',
                'selectable'  => false,
                'filterable'  => false,
                'sortable'    => false,
            ],
        ];
    }
}
