<?php

namespace Unite\UnisysApi\Modules\System\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'system';

    protected $filesystem;

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\System\\SystemServiceProvider'
        ]);

        $this->call('migrate');
    }
}