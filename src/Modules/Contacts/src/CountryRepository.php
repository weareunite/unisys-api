<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Repositories\Repository;

/**
 * @method Country newQuery()
 */
class CountryRepository extends Repository
{
    protected $modelClass = Country::class;

    /**
     * Returns one country
     */
    public function getOne(int $id)
    {
        return $this->newQuery()->getOne($id);
    }

    /**
     * Returns a list of countries
     */
    public function getList(string $sort = null)
    {
        return $this->newQuery()->getList($sort);
    }

    /**
     * Returns a list of countries suitable to use with a select element in Laravelcollective\html
     * Will show the value and sort by the column specified in the display attribute
     */
    public function getListForSelect()
    {
        return $this->newQuery()
            ->orderBy('name', 'asc')
            ->get(['id', 'name'])
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getByName(string $name)
    {
        return $this->newQuery()
            ->where('name', '=', $name)
            ->first();

    }
}