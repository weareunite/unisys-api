<?php

namespace Unite\UnisysApi\Modules\Users\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;
use Illuminate\Support\Facades\File;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'users';

    protected function install()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Unite\\UnisysApi\\Modules\\Users\\UserServiceProvider'
        ]);

        //change config/auth.php to use App/User::class
        $this->strReplaceInFile(config_path('auth.php'),
            "App\\User::class",
            "Unite\\UnisysApi\\Modules\\Users\\User::class");

        // Remove User from App/User
        $this->filesystem->delete(app_path('User.php'));

        $this->call('notifications:table');

        $this->call('migrate');
    }

    private function strReplaceInFile($fileName, $find, $replaceWith)
    {
        $content = File::get($fileName);
        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }
}