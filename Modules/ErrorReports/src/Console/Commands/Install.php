<?php

namespace Unite\UnisysApi\Modules\ErrorReports\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'errorReports';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\ErrorReports\\ErrorReportsServiceProvider'
        ]);

        $this->call('migrate');
    }
}