<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ContactProfileInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'ContactProfileInput',
        'description' => 'A Contact Profile Input',
    ];

    public function fields()
    : array
    {
        return [
            'name'              => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'surname'           => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'company'           => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                    'max:150',
                ],
            ],
            'street'            => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

            ],
            'zip'               => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'city'              => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'country_id'        => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'integer',
                    'exists:countries,id',
                ],
            ],
            'reg_no'            => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'tax_no'            => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'vat_no'            => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'web'               => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'email'             => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'email',
                ],
            ],
            'telephone'         => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:150',
                ],
            ],
            'description'       => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'string',
                    'max:250',
                ],
            ],
        ];
    }
}