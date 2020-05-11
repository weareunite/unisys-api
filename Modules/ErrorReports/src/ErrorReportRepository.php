<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Unite\UnisysApi\Repositories\Repository;

class ErrorReportRepository extends Repository
{
    protected $modelClass = ErrorReport::class;
}