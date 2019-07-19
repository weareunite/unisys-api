<?php

namespace Unite\UnisysApi\Modules\Properties;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasProperties
{
    public function properties(): MorphMany
    {
        return $this->morphMany(Property::class, 'subject');
    }

    /**
     * @param array $data
     * @return \Unite\UnisysApi\Modules\Properties\Property
     */
    public function addProperty(string $key, string $value)
    {
        return $this->properties()->create(compact($key, $value));
    }

    public function removeProperty(string $key)
    {
        $this->properties()->where('key', '=', $key)->delete();
    }

    public function getProperty(string $key)
    {
        $this->properties()->where('key', '=', $key)->get(['value']);
    }

    public function existProperties()
    {
        return $this->properties()->exists();
    }
}
