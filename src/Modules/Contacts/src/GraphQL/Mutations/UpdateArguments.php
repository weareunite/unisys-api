<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Arguments;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class UpdateArguments extends Arguments
{
    public static function arguments(): array
    {
        return [
            'type'              => [
                'name'  => 'type',
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'in:' . implode(',', Contact::getTypes()),
                ],
            ],
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
                    'required',
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
            'custom_properties' => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                    'array',
                ],
            ],
        ];
    }
}
