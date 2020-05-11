<?php

namespace Unite\UnisysApi\Modules\Help\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'help';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Help\\HelpServiceProvider'
        ]);

        $this->call('migrate');
    }
}