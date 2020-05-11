<?php

namespace Unite\UnisysApi\Modules\Company\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'company';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Company\\CompanyServiceProvider'
        ]);

        $this->call('migrate');
    }
}