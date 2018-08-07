<?php

namespace Unite\UnisysApi\Services\RequestQueryBuilder;

class RelationResolver
{
    public static function getGlobalRelationsMap(): array
    {
        return config('query-filter.global_relation_map');
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function getRealRelation(string $relation): string
    {
        $relationsMap = self::getGlobalRelationsMap();

        if(isset($relationsMap[$relation])) {
            return $relationsMap[$relation];
        }

        return $relation;
    }

    /**
     * @param string $dotRelation
     * @param array $map
     * @return string
     */
    public static function mapRelation(string $dotRelation, array $map): string
    {
        foreach ($map as $key => $value) {
            $dotRelation = str_replace_array($key, [$value], $dotRelation);
        }

        return $dotRelation;
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function relationToTable(string $relation): string
    {
        return str_plural( self::getRealRelation($relation) );
    }

    /**
     * @param string $relation
     * @return bool
     */
    public static function hasMany(string $relation): bool
    {
        $relation = self::getRealRelation($relation);

        return (str_plural($relation) === $relation);
    }

    /**
     * @param string $relation
     * @return bool
     */
    public static function hasManyMorphed(string $relation): bool
    {
        $relation = self::getRealRelation($relation);

        return ends_with($relation, 'ables');
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
    public static function clearRelationId(string $relation): string
    {
        return $relation . '.id';
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function foreignId(string $relation): string
    {
        return str_singular($relation) . '_id';
    }

    /**
     * @param string $relation
     * @return string
     */
    public static function manyMorphedType(string $relation): string
    {
        return str_singular($relation) . '_type';
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
     * @param array $localMap
     * @return string
     */
    public static function onlyRelations(string $dotRelation, array $localMap = []): string
    {
        $dotRelation = self::mapRelation($dotRelation, $localMap);

        $parts = explode('.', $dotRelation);

        array_pop($parts);

        return implode('.', $parts);
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

        $column = array_pop($parts);

        $table = last($parts);

        if(!RelationResolver::hasManyMorphed($table)) {
            $table = self::relationToTable($table);
        }

        return $table . '.' . $column;
    }
}