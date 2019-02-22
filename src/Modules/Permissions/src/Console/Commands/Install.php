<?php

namespace Unite\UnisysApi\Modules\Permissions\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'permissions';

    protected $filesystem;

    protected function install()
    {
        //Spatie Permission
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Permission\\PermissionServiceProvider',
            '--tag' => 'config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Permissions\\PermissionsServiceProvider'
        ]);

        $this->call('migrate');

        $this->call('unisys-api:permissions:sync-permissions');
    }
}