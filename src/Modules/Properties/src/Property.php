<?php

namespace Unite\UnisysApi\Modules\Properties;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Unite\UnisysApi\Models\Model;

class Property extends Model
{
    use LogsActivity;

    protected $primaryKey = ['subject_id', 'subject_type', 'key'];
    public $incrementing = false;

    protected $table = 'properties';

    protected $fillable = [
        'key', 'value',
    ];

    protected static $logAttributes = [
        'key', 'value',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
