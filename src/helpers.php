<?php

if (!function_exists('remove_trailing_zero')) {
    function remove_trailing_zero(float $value, $decimal_point = '.')
    {
        return str_replace($decimal_point . "00", "", (string)number_format($value, 2, $decimal_point, ""));
    }
}

if (!function_exists('price_without_tax')) {
    function price_without_tax($price_with_tax, $tax, bool $round = true)
    {
        $price_without_tax = $price_with_tax / (1 + ($tax / 100));

        if ($round === true) {
            $price_without_tax = round($price_without_tax, 2);
        }

        return $price_without_tax;
    }
}

if (!function_exists('locale_file_path')) {
    function locale_file_path(string $path, string $locale, string $callback_locale = null)
    {
        $localeFilePath = storage_path('app/' . sprintf($path, $locale));

        if (!file_exists($localeFilePath) && !$callback_locale) {
            return null;
        }

        if (!file_exists($localeFilePath) && $callback_locale) {
            $localeFilePath = storage_path('app/' . sprintf($path, $callback_locale));
        }

        if (!file_exists($localeFilePath)) {
            return null;
        }

        return $localeFilePath;
    }
}

if (!function_exists('short_locale_file_path')) {
    function get_short_locale_file_path(string $path, string $locale, string $callback_locale = null)
    {
        $full_path = locale_file_path($path, $locale, $callback_locale);

        $app_path = storage_path('app/');

        return str_replace($app_path, '', $full_path);
    }
}

if (!function_exists('companyProfile')) {
    function companyProfile()
    {
        return app('companyProfile');
    }
}

if (!function_exists('successJsonResponse')) {
    function successJsonResponse()
    {
        return response()->json([
            'data' => [ 'success' => true ],
        ]);
    }
}

if (!function_exists('jsonResponse')) {
    function jsonResponse($data, $status = 200)
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }
}

if (!function_exists('captureExceptionBySentry')) {
    function captureExceptionBySentry(Throwable $exception)
    {
        $app = app();

        if ($app->bound('sentry') && ($app->environment() == 'production' || config('unisys.force_sentry') == 'true')) {
            $app->make('sentry', [])->captureException($exception);
        }
    }
}

