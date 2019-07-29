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
        return $this->properties()->where('key', '=', $key)->delete();
    }

    public function getProperty(string $key)
    {
        return $this->properties()->where('key', '=', $key)->first(['value']);
    }

    public function existProperty(string $key)
    {
        return $this->properties()->where('key', '=', $key)->exists();
    }

    public function updateProperty(string $key, string $value)
    {
        if($property = $this->getProperty($key)) {
            return $property->update(compact($value));
        }

        return false;
    }

    public function addOrUpdateProperty(string $key, string $value)
    {
        if($property = $this->getProperty($key)) {
            return $property->update(compact($value));
        } else {
            return $this->addProperty($key, $value);
        }
    }

    public function existProperties()
    {
        return $this->properties()->exists();
    }

    public function handleProperties($properties = null, bool $forceAdd = false)
    {
        if ($properties) {
            if ($forceAdd) {
                $fn = 'addProperty';
            } else {
                $fn = 'addOrUpdateProperty';
            }

            foreach ($properties as $property) {
                $this->$fn($property['key'], $property['value']);
            }
        }
    }
}
