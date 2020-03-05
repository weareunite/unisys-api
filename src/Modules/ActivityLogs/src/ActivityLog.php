<?php

namespace Unite\UnisysApi\Modules\ActivityLogs;

use Unite\UnisysApi\QueryFilter\HasQueryFilter;

class ActivityLog extends \Spatie\Activitylog\Models\Activity
{
    use HasQueryFilter;
}
