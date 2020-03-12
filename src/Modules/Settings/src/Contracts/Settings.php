<?php

namespace Unite\UnisysApi\Modules\Settings\Contracts;

use Illuminate\Contracts\Foundation\Application;

interface Settings
{
    public static function load(Application $application, string $table);

    public function getConfig();

    public function getTable()
    : string;

    public function getKeyValueFormat()
    : array;

    public function updateByKey(string $key, $value = null);

    public function createNew(string $key, $value = null);

    public function deleteByKey(string $key);
}