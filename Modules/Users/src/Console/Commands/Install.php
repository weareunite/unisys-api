<?php

namespace Unite\UnisysApi\Modules\Users\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'users';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Users\\UsersServiceProvider'
        ]);

        //change config/auth.php to use App/User::class
        $this->strReplaceInFile(config_path('auth.php'),
            "App\\User::class",
            "Unite\\UnisysApi\\Modules\\Users\\User::class");

        // Remove User from App/User
        $this->fileSystem->delete(app_path('User.php'));

        $this->call('notifications:table');

        $this->call('migrate');
    }
}