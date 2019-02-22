<?php

namespace Unite\UnisysApi\Modules\Transactions\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'transactions';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Transactions\\TransactionsServiceProvider'
        ]);

        $this->call('migrate');
    }
}