<?php

namespace Unite\UnisysApi\Modules\Properties;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Unite\UnisysApi\Modules\Properties\Exceptions\PropertyDoesNotExistsException;

trait HasProperties
{
    public function properties()
    : MorphMany
    {
        return $this->morphMany(Property::class, 'subject');
    }

    /**
     * @param array $data
     * @return \Unite\UnisysApi\Modules\Properties\Property
     */
    public function addProperty(string $key, string $value = null)
    {
        return $this->properties()->create(compact('key', 'value'));
    }

    public function removeProperty(string $key)
    {
        return $this->properties()->where('key', '=', $key)->delete();
    }

    public function getProperty(string $key)
    : ?Property
    {
        return $this->properties()->where('key', '=', $key)->first([ 'value' ]);

    }

    public function getPropertyValue(string $key)
    : ?string
    {
        if ($object = $this->getProperty($key)) {
            return $object->value;
        }

        return PropertyDoesNotExistsException::named($key);
    }

    public function existProperty(string $key)
    : bool
    {
        return $this->properties()->where('key', '=', $key)->exists();
    }

    public function hasProperty(string $key)
    : bool
    {
        return $this->existProperty($key);
    }

    public function updateProperty(string $key, string $value = null)
    {
        if ($property = $this->getProperty($key)) {
            return $property->update(compact('value'));
        }

        return false;
    }

    public function addOrUpdateProperty(string $key, string $value = null)
    {
        if ($property = $this->getProperty($key)) {
            return $property->update(compact('value'));
        } else {
            return $this->addProperty($key, $value);
        }
    }

    public function existProperties()
    : bool
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
