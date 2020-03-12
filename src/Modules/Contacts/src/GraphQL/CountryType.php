<?php

namespace Unite\UnisysApi\Modules\Contacts\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Contacts\Models\Country;

class CountryType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Country',
        'description' => 'A country',
        'model'       => Country::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'                => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of country',
            ],
            'capital'           => [
                'type'        => Type::string(),
                'description' => 'The capital of country',
            ],
            'citizenship'       => [
                'type'        => Type::string(),
                'description' => 'The citizenship of country',
            ],
            'country_code'      => [
                'type'        => Type::string(),
                'description' => 'The country_code of country',
            ],
            'currency'          => [
                'type'        => Type::string(),
                'description' => 'The currency of country',
            ],
            'currency_code'     => [
                'type'        => Type::string(),
                'description' => 'The currency_code of country',
            ],
            'currency_sub_unit' => [
                'type'        => Type::string(),
                'description' => 'The currency_sub_unit of country',
            ],
            'currency_symbol'   => [
                'type'        => Type::string(),
                'description' => 'The currency_symbol of country',
            ],
            'currency_decimals' => [
                'type'        => Type::string(),
                'description' => 'The currency_decimals of country',
            ],
            'full_name'         => [
                'type'        => Type::string(),
                'description' => 'The full_name of country',
            ],
            'iso_3166_2'        => [
                'type'        => Type::string(),
                'description' => 'The iso_3166_2 of country',
            ],
            'iso_3166_3'        => [
                'type'        => Type::string(),
                'description' => 'The iso_3166_3 of country',
            ],
            'name'              => [
                'type'        => Type::string(),
                'description' => 'The name of country',
            ],
            'region_code'       => [
                'type'        => Type::string(),
                'description' => 'The region_code of country',
            ],
            'sub_region_code'   => [
                'type'        => Type::string(),
                'description' => 'The sub_region_code of country',
            ],
            'eea'               => [
                'type'        => Type::string(),
                'description' => 'The eea of country',
            ],
            'calling_code'      => [
                'type'        => Type::string(),
                'description' => 'The calling_code of country',
            ],
            'flag'              => [
                'type'        => Type::string(),
                'description' => 'The flag of country',
            ],
        ];
    }
}

