<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'activityLogs';

    protected function install()
    {
        //Spatie Log activity
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
            '--tag' => 'config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\ActivityLogs\\ActivityLogServiceProvider'
        ]);

        $this->call('migrate');

        //change config/activitylog.php to use App/User::class
        $this->strReplaceInFile(config_path('activitylog.php'),
            "Spatie\\Activitylog\\Models\\Activity::class",
            "Unite\\UnisysApi\\Modules\\ActivityLogs\\ActivityLog::class");
    }
}