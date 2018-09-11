<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

use Illuminate\Support\Arr;
use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\DataItem;
use Unite\UnisysApi\QueryBuilder\Types\Filter;

class FilterParser extends Parser
{
    /** @var Column */
    protected $column;

    /** @var string */
    protected $operator;

    /** @var \Illuminate\Support\Collection|DataItem[] */
    protected $data;

    protected function handle($value = null)
    {
        $rawFilters = $value ? json_decode(base64_decode($value)) : [];
        $rawFilters = $rawFilters ?: [];

        $filters = [];

        foreach ($rawFilters as $column => $filter) {
            $this->column = $this->resolveColumn($column);

            $this->reset();

            $filters[] = $this->createFilter($filter);
        }

        return collect($filters);
    }

    protected function reset()
    {
        $this->operator = 'or';
        $this->data = collect();
    }

    protected function createFilter($value)
    {
//        {
//        "grant_budget_items.grant.id": [
//            22
//          ]
//        "draws_count": ">1"
//        "supplier.id": [
//            256
//          ]
//}

//     [
//       Filter {
//        column: "grant_budget_items.grant.id"
//        operator: "or"
//        data:
//          [
//              DataItem {
//                operator: "="
//                value: "22"
//              }
//          ]
//      },

//      Filter {
//        column: "draws_count"
//        operator: "or"
//        data:
//            [
//            DataItem {
//                operator: ">"
//                value: "1"
//            }
//          ]
//      },

//      Filter {
//        column: "supplier.id"
//        operator: "or"
//        data:
//            [
//            DataItem {
//                operator: "="
//                value: "256"
//              }
//          ]
//      }
//  ]

//        select count(*) as aggregate
//          from `expenses`
//          inner join `draws` on `expenses`.`id` = `draws`.`expense_id`
//          inner join `grant_budget_items` on `draws`.`grant_budget_item_id` = `grant_budget_items`.`id`
//          inner join `grants` on `grant_budget_items`.`grant_id` = `grants`.`id`
//          inner join `contacts` on `expenses`.`id` = `contacts`.`expense_id` => inner join `contacts` on `expenses`.`supplier_id` = `contacts`.`id`
//        where (`grants`.`id` = 22) and (`expenses`.`draws_count` > 1) and (`contacts`.`id` = 256)

        switch (gettype($value)) {
            case 'object':
                $this->parseObject($value);
                break;
            case 'array':
                $this->parseArray($value);
                break;
            case 'string':
                $this->parseString($value);
                break;
            default:
                break;
        }

        return new Filter($this->column, $this->operator, $this->data);
    }

    protected function parseObject(object $value)
    {
        if (in_array($value->operator, [ 'and', 'or', 'between' ])) {
            $this->operator = $value->operator;
        }

        if (Arr::accessible($value->data)) {
            $this->parseArray($value->data);
        } else {
            $this->parseString($value->data);
        }
    }

    protected function parseArray(array $valueArray)
    {
        foreach ($valueArray as $value) {
            $this->parseString($value);
        }
    }

    protected function parseString(string $value)
    {
        $this->data->push($this->parseFilterValue($value));
    }

    protected static function parseFilterValue(string $value)
    : DataItem
    {
        $operator = '=';
        $firstChar = substr($value, 0, 1);

        if (in_array($firstChar, ['<', '>', '=', '%'])) {
            $value = substr($value, 1);

            switch ($firstChar) {
                case '<':
                    $operator = '<';
                    break;
                case '>':
                    $operator = '>';

                    break;
                case '%':
                    $operator = 'like';
                    $value = $value . '%';
                    break;
            }
        }

        return new DataItem($operator, $value);
    }
}