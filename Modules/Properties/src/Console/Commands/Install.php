<?php

namespace Unite\UnisysApi\Modules\Properties\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'properties';

    protected $filesystem;

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Properties\\PropertiesServiceProvider'
        ]);

        $this->call('migrate');
    }
}