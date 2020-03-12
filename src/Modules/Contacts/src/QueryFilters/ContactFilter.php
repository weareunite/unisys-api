<?php

namespace Unite\UnisysApi\Modules\Contacts\QueryFilters;

use Unite\UnisysApi\QueryFilter\QueryFilter;

class ContactFilter extends QueryFilter
{
    public function filterIsAbroad(array $values)
    {
        return $this->query->join('countries', 'countries.id', '=', 'contacts.country_id')
            ->whereIn('countries.country_id', $values);
    }
}
