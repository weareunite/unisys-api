<?php

namespace Unite\UnisysApi\Modules\ActivityLogs;

use Spatie\Activitylog\Models\Activity;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class ActivityLog extends Activity implements HasQueryFilterInterface
{
    use HasQueryFilter;
}
