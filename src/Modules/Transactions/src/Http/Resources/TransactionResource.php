<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Resources;

use Unite\UnisysApi\Modules\Transactions\Models\Transaction;
use Unite\UnisysApi\Http\Resources\Resource;

class TransactionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Modules\Transactions\Models\Transaction $this->resource */
        return [
            'id'                 => $this->id,
            'type'               => $this->type,
            'subject_type'       => $this->subject_type,
            'subject_id'         => $this->subject_id,
            'amount'             => $this->amount,
            'balance'            => $this->balance,
            'variable_symbol'    => (int)$this->variable_symbol,
            'specific_symbol'    => (int)$this->specific_symbol,
            'description'        => $this->description,
            'posted_at'          => (string)$this->posted_at,
            'created_at'         => (string)$this->created_at,
            'destination_iban'   => $this->destination_iban,
            'transaction_source' => new SourceResource($this->source)
        ];
    }

    public static function modelClass()
    {
        return Transaction::class;
    }

    public static function resourceMap()
    {
        $map = [
            'transaction_source' => SourceResource::class
        ];

        return parent::resourceMap()->merge($map);
    }
}
