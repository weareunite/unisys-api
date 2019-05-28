<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Resources;

use Illuminate\Database\Eloquent\Builder;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Http\Resources\Resource;

class ContactResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Modules\Contacts\Models\Contact $this->resource */
        return [
            'id'                => $this->id,
            'type'              => $this->type,
            'name'              => $this->name,
            'surname'           => $this->surname,
            'company'           => $this->company,
            'street'            => $this->street,
            'zip'               => $this->zip,
            'city'              => $this->city,
            'country'           => new CountryResource($this->country),
            'abroad'            => $this->isAbroad(),
            'reg_no'            => $this->reg_no,
            'tax_no'            => $this->tax_no,
            'vat_no'            => $this->vat_no,
            'web'               => $this->web,
            'email'             => $this->email,
            'telephone'         => $this->telephone,
            'description'       => $this->description,
            'custom_properties' => $this->custom_properties,
        ];
    }

    public static function modelClass()
    {
        return Contact::class;
    }

    public static function eagerLoads()
    {
        $with = [
            'country',
        ];

        return parent::eagerLoads()->merge($with);
    }

    public static function resourceMap()
    {
        $map = [
            'country' => CountryResource::class
        ];

        return parent::resourceMap()->merge($map);
    }

    public static function virtualFields()
    {
        $virtualFields = [
            'abroad' => function (Builder &$query, $value) {
                $company = app('companyProfile');

                if($value === 'yes') {
                    $sql = 'contacts.country_id <> ' . $company->country_id;
                } elseif ($value === 'no') {
                    $sql = 'contacts.country_id = ' . $company->country_id;
                } else {
                    $sql = 'contacts.country_id = ' . $company->country_id;
                }

                return $query->orWhereRaw($sql);
            }
        ];

        return parent::virtualFields()->merge($virtualFields);
    }
}