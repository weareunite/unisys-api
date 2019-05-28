<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Resources;

use Illuminate\Database\Eloquent\Builder;
use Unite\UnisysApi\Modules\Transactions\Models\Source;
use Unite\UnisysApi\Http\Resources\Resource;

class SourceResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \Unite\UnisysApi\Modules\Transactions\Models\Source $this->resource */
        return [
            'id'                => $this->id,
            'type'              => $this->type,
            'balance'           => $this->balance,
            'is_bank_account'   => $this->isBankAccount(),
            'name'              => $this->name,
            'short_name'        => $this->short_name,
            'iban'              => $this->iban,
            'bic'               => $this->bic,
            'swift'             => $this->swift,
            'description'       => $this->description,
            'created_at'        => (string)$this->created_at,
        ];
    }

    public static function modelClass()
    {
        return Source::class;
    }

    public static function virtualFields()
    {
        $virtualFields = [
            'is_bank_account' => function (Builder &$query, $value) {

                $sql = 'transaction_sources.type = ' . Source::TYPE_BANK_ACCOUNT;

                return $query->orWhereRaw($sql);

            }
        ];

        return parent::virtualFields()->merge($virtualFields);
    }
}