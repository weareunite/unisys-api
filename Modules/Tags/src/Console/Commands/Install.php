<?php

namespace Unite\UnisysApi\Modules\Tags\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'tags';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Tags\\TagsServiceProvider'
        ]);

        $this->call('migrate');
    }
}