<?php

namespace Unite\UnisysApi\Helpers\CustomProperty;

/**
 * @property array $custom_properties
 */
trait HasCustomPropertyTrait {

    /*
     * Determine if the media item has a custom property with the given name.
     */
    public function hasCustomProperty(string $propertyName): bool
    {
        return array_has($this->custom_properties, $propertyName);
    }

    /**
     * Get if the value of custom property with the given name.
     *
     * @param string $propertyName
     * @param mixed $default
     *
     * @return mixed
     */
    public function getCustomProperty(string $propertyName, $default = null)
    {
        return array_get($this->custom_properties, $propertyName, $default);
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setCustomProperty(string $name, $value)
    {
        $customProperties = $this->custom_properties;

        array_set($customProperties, $name, $value);

        $this->custom_properties = $customProperties;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function forgetCustomProperty(string $name)
    {
        $customProperties = $this->custom_properties;

        array_forget($customProperties, $name);

        $this->custom_properties = $customProperties;

        return $this;
    }

    public function setCustomPropertiesAttribute($value = null)
    {
        if($value === null) {
            return;
        }

        $this->attributes['custom_properties'] = json_encode($value);
    }
}