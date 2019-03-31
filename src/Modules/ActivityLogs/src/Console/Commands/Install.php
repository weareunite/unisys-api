<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'activityLogs';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\ActivityLogs\\ActivityLogServiceProvider'
        ]);
    }
}