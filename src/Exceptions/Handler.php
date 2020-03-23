<?php

namespace Unite\UnisysApi\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\OAuth2\Server\Exception\OAuthServerException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        OAuthServerException::class,
    ];

    public function report(Throwable $exception)
    {
        if($this->shouldReport($exception)) {
            captureExceptionBySentry($exception);
        }

        parent::report($exception);
    }


}
