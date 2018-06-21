<?php

namespace Unite\UnisysApi\Helpers\Prefix;

trait HasPrefixTrait {

    public function prefix($str = "", $package = null) {
        return (!is_null($package) ? $package.'::' : '') . $this->moduleName() . ($str ? '.' . (string) $str : '');
    }

    protected function moduleName() {

        list ($class) = array_slice(array_reverse(explode('\\', get_called_class())), 0, 2);

        $class = lcfirst(str_replace('Controller', '', $class));

        return $class;
    }

}