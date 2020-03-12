<?php

namespace Unite\UnisysApi\Modules\Invoice\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'invoice';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Invoice\\InvoiceServiceProvider',
        ]);

        $this->call('invoices:install');

        $this->call('migrate');
    }
}