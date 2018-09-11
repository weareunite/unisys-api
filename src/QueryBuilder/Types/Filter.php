<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Illuminate\Support\Collection;

class Filter extends Type
{
    /** @var Column */
    public $column;

    /** @var string */
    public $operator;

    /** @var Collection|DataItem[]|DataItem */
    public $data;

    public function __construct(Column $column, string $operator, $data)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->data = $data;
    }

    public function getDataValues(): array
    {
        if($this->data instanceof DataItem) {
            return [$this->data->value];
        }

        $values = [];

        foreach ($this->data as $dataItem) {
            $values[] = $dataItem->value;
        }

        return $values;
    }

//    public function parse2222()
//    {
//        $this->requestValue = $this->requestValue ? json_decode($this->requestValue) : [];
//
//        $parsedFilter = [];
//        $parsedFilterGroup = [];
//
//        foreach ($this->requestValue as $column => $value) {
//            $this->decideFilterValue($value);
//            if (Arr::accessible($value)) {
//                foreach ($value as $k => $item) {
//                    if (in_array($k, [ 'and', 'or', 'between' ])) {
//                        if ($k === 'between') {
//                            if (!Arr::accessible($item) || count($item) != 2) {
//                                throw InvalidFilter::invalidBetween();
//                            }
//
//                            $parsedFilterGroup[ $column ]['between'] = new FilterBetween($column, $item);
//                        } else {
//                            if (!Arr::accessible($item)) {
//                                throw InvalidFilter::notArrayValue();
//                            }
//
//                            foreach ($item as $item_item) {
//                                $parsedFilterGroup[ $column ][ $k ][] = $this->createFilter($column, $item_item);
//                            }
//                        }
//                    } else {
//                        if (Arr::accessible($item)) {
//                            throw InvalidFilter::notStringValue();
//                        }
//
//                        $parsedFilterGroup[ $column ]['or'][] = $this->createFilter($column, $item);
//                    }
//                }
//            } else {
//                $parsedFilter[] = $this->createFilter($column, $value);
//            }
//        }
//
//        return [
//            'filter' => $parsedFilter,
//            'filterGroup' => $parsedFilterGroup
//        ];
//    }
}