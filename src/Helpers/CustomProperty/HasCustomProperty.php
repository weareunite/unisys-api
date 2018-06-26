<?php

namespace Unite\UnisysApi\Helpers\CustomProperty;

interface HasCustomProperty
{
    /*
     * Determine if the media item has a custom property with the given name.
     */
    public function hasCustomProperty(string $propertyName): bool;

    /**
     * Get if the value of custom property with the given name.
     *
     * @param string $propertyName
     * @param mixed $default
     *
     * @return mixed
     */
    public function getCustomProperty(string $propertyName, $default = null);

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function setCustomProperty(string $name, $value);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function forgetCustomProperty(string $name);
}