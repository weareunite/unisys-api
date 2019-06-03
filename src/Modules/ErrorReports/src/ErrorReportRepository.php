<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Unite\UnisysApi\Repositories\Repository;

/**
 * @method ErrorReport getQueryBuilder()
 */
class ErrorReportRepository extends Repository
{
    protected $modelClass = ErrorReport::class;
}