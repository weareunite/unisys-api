<?php

namespace Unite\UnisysApi\Services\RequestQueryBuilder;

class RelationResolver
{
    public static function getRelationsMap(): array
    {
        return config('query-filter.relation_map');
    }

    public static function toArray(string $relations): array
    {
        array_set($array, self::onlyRelations($relations), '');

        return $array;
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function relationToTable(string $relation): string
    {
        $relationsMap = self::getRelationsMap();

        if(isset($relationsMap[$relation])) {
            return $relationsMap[$relation];
        }

        return str_plural($relation);
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function relationId(string $relation): string
    {
        return self::relationToTable($relation) . '.id';
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function foreignId(string $relation): string
    {
        return $relation . '_id';
    }

    /**
     * @param string $column
     * @return bool
     */
    public static function hasRelation(string $column): bool
    {
        return (strpos($column, "."));
    }

    /**
     * @param string $dotRelation
     * @return string
     */
    public static function onlyRelations(string $dotRelation): string
    {
        $parts = explode('.', $dotRelation);

        return implode('.', array_pop($parts));
    }

    /**
     * @param string $dotRelation
     * @return string
     */
    public static function onlyColumn(string $dotRelation): string
    {
        $parts = explode('.', $dotRelation);

        return last($parts);
    }

    /**
     * @param string $dotRelation
     * @return string
     */
    public static function columnWithTable(string $dotRelation): string
    {
        $parts = explode('.', $dotRelation);

        $lastRelation = last(array_pop($parts));

        $column = last($parts);

        return self::relationToTable($lastRelation) . '.' . $column;
    }
}