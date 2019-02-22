<?php

namespace Unite\UnisysApi\Modules\Media\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'media';

    protected $filesystem;

    protected function install()
    {
        //Spatie medialibrary
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
            '--tag' => 'config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Media\\MediaServiceProvider'
        ]);

        $this->call('migrate');
    }
}