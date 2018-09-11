<?php

namespace Unite\UnisysApi\QueryBuilder;

class QueryResolver
{
    public function asdasd($query)
    {
        $col = 'draw_state';

        if($column === $col) {
            $query->addSelect(
                DB::raw(
'CASE
   WHEN expenses.amount = expenses.drawn THEN ' . Expense::DRAW_STATE_DRAWN . '
   WHEN expenses.amount = 0 THEN ' . Expense::DRAW_STATE_UNDRAWN . '
   WHEN expenses.amount < expenses.drawn THEN ' . Expense::DRAW_STATE_OVERDRAWN . '
   WHEN expenses.amount > expenses.drawn THEN ' . Expense::DRAW_STATE_PARTIALLY_DRAWN . '
END AS '. $col)
            );

            if($value = Expense::DRAW_STATE_DRAWN) {
                $whereRaw = 'CASE WHEN expenses.amount = expenses.drawn THEN TRUE ELSE FALSE END';
            }

            if($value = Expense::DRAW_STATE_UNDRAWN) {
                $whereRaw = 'CASE WHEN expenses.amount = 0 THEN TRUE ELSE FALSE END';
            }

            if($value = Expense::DRAW_STATE_OVERDRAWN) {
                $whereRaw = 'CASE WHEN expenses.amount < expenses.drawn THEN TRUE ELSE FALSE END';
            }

            if($value = Expense::DRAW_STATE_PARTIALLY_DRAWN) {
                $whereRaw = 'CASE WHEN expenses.amount > expenses.drawn THEN TRUE ELSE FALSE END';
            }

            $query->where(DB::raw($whereRaw));

        }

    }


}