<?php

namespace Unite\UnisysApi\Modules\System\Http\Controllers;

use Unite\UnisysApi\Modules\Settings\Http\Controllers\SettingController as BaseSettingController;
use Unite\UnisysApi\Modules\System\SystemSettings;

final class SettingController extends BaseSettingController
{
    protected function getSettingClass()
    : string
    {
        return SystemSettings::class;
    }
}
