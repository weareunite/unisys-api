<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\Partner;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Contacts\PartnerRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updatePartner',
    ];

    public function repositoryClass()
    : string
    {
        return PartnerRepository::class;
    }

    public function args()
    {
        return [
            'id'       => [
                'type' => Type::string(),
                'rules' => [
                    'required',
                    'numeric',
                    'exists:users,id',
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
