<?php

namespace Unite\UnisysApi\Helpers\Prefix;

/**
 * Interface HasPrefix
 *
 * This interface provides helper for organizing a structure of this package. It provides a shortcut
 * for the:
 *  - name of the current's admin controller ability (permission)
 *  - name of the blade resource
 *  - ...
 *
 * Note: Usage of this feature should not be overrated, it should help you by providing a shortcut.
 * If you need some advanced permissions system or you want to organize your file structure differently,
 * avoid using HasPrefix at all.
 */
interface HasPrefix {

    public function prefix($str = "", $package = null);

}