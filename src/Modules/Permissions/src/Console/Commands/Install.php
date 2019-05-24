<?php

namespace Unite\UnisysApi\Modules\Permissions\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'permissions';

    protected $filesystem;

    protected function install()
    {
        //change Permission model in config/permission.php
        $this->strReplaceInFile(config_path('permission.php'),
            "Spatie\\Permission\\Models\\Permission::class",
            "Unite\\UnisysApi\\Modules\\Permissions\\Permission::class");

        //change Role model in config/permission.php
        $this->strReplaceInFile(config_path('permission.php'),
            "Spatie\\Permission\\Models\\Role::class",
            "Unite\\UnisysApi\\Modules\\Permissions\\Role::class");

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