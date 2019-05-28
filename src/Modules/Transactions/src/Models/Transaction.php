<?php

namespace Unite\UnisysApi\Modules\Transactions\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Unite\UnisysApi\Modules\Transactions\Events\TransactionCreating;
use Unite\UnisysApi\Modules\Transactions\Events\TransactionDeleting;
use Unite\UnisysApi\Modules\Transactions\Events\TransactionSaving;
use Unite\UnisysApi\Modules\Transactions\Events\TransactionUpdating;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Users\HasInstance;

/**
 * @property \Unite\UnisysApi\Models\Model $subject
 */
class Transaction extends Model
{
    use LogsActivity;
    use HasInstance;

    protected $table = 'transactions';

    protected $fillable = [
        'type', 'transaction_source_id', 'destination_iban', 'amount', 'variable_symbol', 'specific_symbol', 'description', 'posted_at',
    ];

    protected static $logAttributes = [
        'type', 'transaction_source_id', 'destination_iban', 'amount', 'variable_symbol', 'specific_symbol', 'description', 'posted_at',
    ];

    protected $dispatchesEvents = [
        'creating'  => TransactionCreating::class,
        'updating'  => TransactionUpdating::class,
        'saving'    => TransactionSaving::class,
        'deleting'  => TransactionDeleting::class,
    ];

    const TYPE_CREDIT   = 'credit';
    const TYPE_DEBIT    = 'debit';
    const TYPE_CARD     = 'card';

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'transaction_source_id');
    }

    public function transactionSource()
    {
        return $this->source();
    }

    public static function getTypes(): array
    {
        return [
            self::TYPE_CREDIT,
            self::TYPE_DEBIT,
            self::TYPE_CARD,
        ];
    }

    public static function getDefaultType(): string
    {
        return self::TYPE_DEBIT;
    }

    public function getCurrentSourceBalance(): float
    {
        return $this->source->balance;
    }

    public function calculateBalanceBySource(): float
    {
        $currentSourceBalance = $this->getCurrentSourceBalance();

        if($this->type === self::TYPE_CREDIT) {
            return $currentSourceBalance + $this->amount;
        } else {
            return $currentSourceBalance - $this->amount;
        }
    }
}
