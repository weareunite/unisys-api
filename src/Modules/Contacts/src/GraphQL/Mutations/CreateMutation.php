<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Contacts\ContactRepository;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createContact',
    ];

    public function repositoryClass()
    : string
    {
        return ContactRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Contact');
    }

    public function args()
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
