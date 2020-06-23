<?php

namespace Unite\UnisysApi\Modules\Settings\Contracts;

use Illuminate\Contracts\Foundation\Application;

interface Settings
{
    public static function load(Application $application, string $table);

    public function getConfig();

    public function getTable()
    : string;

    public function getKeyValueFormat(bool $decrypt = false)
    : array;

    public function updateByKey(string $key, $value = null, bool $encrypt = false);

    public function createNew(string $key, $value = null, bool $encrypt = false);

    public function deleteByKey(string $key);
}