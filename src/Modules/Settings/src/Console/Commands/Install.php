<?php

namespace Unite\UnisysApi\Modules\Settings\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'settings';

    protected $filesystem;

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Settings\\SettingsServiceProvider'
        ]);

        $this->call('migrate');
    }
}