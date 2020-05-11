<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class ContactType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Contact',
        'description' => 'A contact',
        'model'       => Contact::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'                => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of contact',
            ],
            'type'              => [
                'type'        => Type::string(),
                'description' => 'The type of contact',
            ],
            'name'              => [
                'type'        => Type::string(),
                'description' => 'The name of contact',
            ],
            'surname'           => [
                'type'        => Type::string(),
                'description' => 'The surname of contact',
            ],
            'company'           => [
                'type'        => Type::string(),
                'description' => 'The company of contact',
            ],
            'street'            => [
                'type'        => Type::string(),
                'description' => 'The street of contact',
            ],
            'zip'               => [
                'type'        => Type::string(),
                'description' => 'The zip of contact',
            ],
            'city'              => [
                'type'        => Type::string(),
                'description' => 'The city of contact',
            ],
            'country'           => [
                'type'        => GraphQL::type('Country'),
                'description' => 'The country of contact',
            ],
            'is_abroad'         => [
                'type'        => Type::string(),
                'description' => 'The is abroad of contact',
                'selectable'  => false,
            ],
            'reg_no'            => [
                'type'        => Type::string(),
                'description' => 'The reg_no of contact',
            ],
            'tax_no'            => [
                'type'        => Type::string(),
                'description' => 'The tax_no of contact',
            ],
            'vat_no'            => [
                'type'        => Type::string(),
                'description' => 'The vat_no of contact',
            ],
            'web'               => [
                'type'        => Type::string(),
                'description' => 'The web of contact',
            ],
            'email'             => [
                'type'        => Type::string(),
                'description' => 'The email of contact',
            ],
            'telephone'         => [
                'type'        => Type::string(),
                'description' => 'The telephone of contact',
            ],
            'description'       => [
                'type'        => Type::string(),
                'description' => 'The description of contact',
            ],
        ];
    }
}

