<?php

namespace Unite\UnisysApi\Http\Resources;

use Closure;
use Illuminate\Http\Resources\Json\Resource as BaseResource;
use Illuminate\Support\Collection;

abstract class Resource extends BaseResource
{
    abstract public static function modelClass();

    public static function eagerLoads()
    {
        return collect();
    }

    public static function tableTrough()
    {
        return collect();
    }

    public static function virtualFields()
    {
        return collect();
    }

    public static function resourceMap()
    {
        return collect();
    }

    /**
     * @param \Unite\UnisysApi\Http\Resources\Resource $resourceClass
     */
    public static function getEagerLoads(string $parentRelation = null, string $resourceClass = null, Collection $eagerLoads = null)
    {
        if($eagerLoads === null) {
            $eagerLoads = collect();
        }

        if($resourceClass === null) {
            $resourceClass = static::class;
        }

        $resourceMaps = $resourceClass::resourceMap();

        foreach ($resourceMaps as $relation => $resource) {
            if($parentRelation) {
                $relation = $parentRelation . '.' . $relation;
            }

            $eagerLoads->push(camel_case($relation));

            self::getEagerLoads($relation, $resource, $eagerLoads);
        }

        return $eagerLoads->toArray();
    }

    /**
     * @param \Unite\UnisysApi\Http\Resources\Resource $resourceClass
     */
    public static function getVirtualFields(string $resourceClass = null, array &$virtualFields = null)
    {
        if($virtualFields === null) {
            $virtualFields = [];
        }

        if($resourceClass === null) {
            $resourceClass = static::class;
        }

        /** @var $resource static  */
        $a = $resourceClass::modelClass();
        $table =  with(new $a)->getTable();

        $resourceClass::virtualFields()->each(function(Closure $fn, string $column) use ($table, &$virtualFields) {
            $virtualFields[$table . '.' . $column] = $fn;
        });

        $resourceMaps = $resourceClass::resourceMap();

        foreach ($resourceMaps as $resource) {
            static::getVirtualFields($resource, $virtualFields);
        }

        return $virtualFields;
    }
}

