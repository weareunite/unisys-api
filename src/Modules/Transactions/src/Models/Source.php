<?php

namespace Unite\UnisysApi\Modules\Transactions\Models;

use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Users\HasInstance;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Modules\Transactions\Models\Source whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Modules\Transactions\Models\Source whereShortName($value)
 */
class Source extends Model
{
    use HasInstance;

    protected $table = 'transaction_sources';

    protected $fillable = [
        'type', 'name', 'short_name', 'iban', 'bic', 'swift', 'description',
    ];

    const TYPE_BANK_ACCOUNT = 'bank-account';
    const TYPE_CASH_DESK    = 'cash-desk';
    const TYPE_CREDIT_CARD  = 'credit-card';

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_BANK_ACCOUNT,
            self::TYPE_CASH_DESK,
            self::TYPE_CREDIT_CARD,
        ];
    }

    public function isBankAccount(): bool
    {
        return ($this->type === self::TYPE_BANK_ACCOUNT);
    }

    public function getIsBankAccountAttribute()
    {
        return $this->isBankAccount();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBankAccount($query)
    {
        $sql = $this->virtualIsBankAccount() . ' = ' . true;

        return $query->whereRaw($sql);
    }

    public function virtualIsBankAccount(): string
    {
        return 'CASE WHEN transaction_sources.type = ' . self::TYPE_BANK_ACCOUNT . ' THEN true ELSE false END';
    }
}
