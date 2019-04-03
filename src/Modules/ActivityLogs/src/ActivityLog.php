<?php

namespace Unite\UnisysApi\Modules\ActivityLogs;

use Unite\UnisysApi\QueryBuilder\HasQueryFilter;

class ActivityLog extends \Spatie\Activitylog\Models\Activity
{
    use HasQueryFilter;
}
