<?php

namespace Unite\UnisysApi\Modules\Export\Http\Controllers;

use Illuminate\Support\Arr;
use Maatwebsite\Excel\Excel;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Export\DataExport;
use Unite\UnisysApi\Modules\Export\Http\ExportRequest;

trait HasExport
{
    use HasModel;

    public function export(ExportRequest $request, DataExport $export)
    {
        $filter = $request->get('filter');
        $keys = $request->get('keys');

        $query = $this->newQuery();

        $relations = self::getRelations(Arr::pluck($keys, 'key'), array_keys($query->getModel()->getCasts()));

        $query = $query->with($relations);

        if ($filter && method_exists($query, 'filter')) {
            $query = $query->filter($filter);
        }

        return $export->setData($query->get()->toArray())
            ->setKeys($keys)
            ->download('export.xlsx', Excel::XLSX);
    }

    private static function hasRelation(string $key)
    : bool
    {
        return (strpos($key, "."));
    }

    private static function relations(string $key)
    : ?string
    {
        if (!self::hasRelation($key)) {
            return null;
        }

        $parts = explode('.', $key);

        array_pop($parts);

        return implode('.', $parts);
    }

    private static function getRelations(array $keys, array $casted)
    {
        $relations = [];

        $keys = array_diff_key($keys, $casted);

        foreach ($keys as $key) {
            $relations[] = self::relations($key);
        }

        return array_unique(array_filter($relations));
    }
}
