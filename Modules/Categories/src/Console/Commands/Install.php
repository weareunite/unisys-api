<?php

namespace Unite\UnisysApi\Modules\Categories\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'categories';

    protected function install()
    {
        $this->call('migrate');
    }
}