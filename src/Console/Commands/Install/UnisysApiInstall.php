<?php

namespace Unite\UnisysApi\Console\Commands\Install;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class UnisysApiInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install a Unisys API skeleton instance';

    /**
     * Password for generated default admin
     *
     * @var string
     */
    protected $password = 'peter is dog';

    /*
     * Execute the console command.
     */
    public function handle(Filesystem $files)
    {
        $this->info('Installing UniSys API skeleton...');

        $this->prepareLaravelApp($files);

        $this->publishAllVendors();

        $this->call('migrate:install');

        $this->call('queue:table');

        $this->call('notifications:table');

        $this->call('migrate');

        $this->call('passport:install', ['--force']);

        $this->call('unisys-api:install:contacts');

        $this->call('unisys:sync-permissions');

        $this->call('unisys:import-users');

        $this->call('unisys:set-company-profile');

//        $this->comment('Admin password is: ' . $this->password);

        $this->info('UniSys API skeleton was installed.');
    }

    private function strReplaceInFile($fileName, $find, $replaceWith)
    {
        $content = File::get($fileName);
        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }

    private function publishAllVendors()
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

        //Spatie Backup
        $this->call('vendor:publish', [
            '--provider' => "Spatie\\Backup\\BackupServiceProvider",
        ]);

        //Spatie Log activity
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
            '--tag' => 'config'
        ]);

        //Spatie medialibrary
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
            '--tag' => 'config'
        ]);

        //Spatie model-status
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\ModelStatus\\ModelStatusServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\ModelStatus\\ModelStatusServiceProvider',
            '--tag' => 'config'
        ]);

        //Barryvdh cors
        $this->call('vendor:publish', [
            '--provider' => 'Barryvdh\\Cors\\ServiceProvider'
        ]);

        //Barryvdh laravel-snappy
        $this->call('vendor:publish', [
            '--provider' => 'Barryvdh\\Snappy\\ServiceProvider'
        ]);

        //Unite unisys-api
        $this->call('vendor:publish', [
            '--provider' => "Unite\\UnisysApi\\UnisysApiServiceProvider",
        ]);
    }

    private function prepareLaravelApp(Filesystem $files)
    {
        $this->info('Preparing laravel app for unisys api ...');

        //change config/auth.php to use App/User::class
        $this->strReplaceInFile(config_path('auth.php'),
            "App\\User::class",
            "Unite\\UnisysApi\\Models\\User::class");

        //change config/auth.php to use default guard to api
        $this->strReplaceInFile(config_path('auth.php'),
            "'guard' => 'web'",
            "'guard' => 'api'");

        //change config/auth.php to use api driver to passport
        $this->strReplaceInFile(config_path('auth.php'),
            "'driver' => 'token'",
            "'driver' => 'passport'");

        // Remove User from App/User
        $files->delete(app_path('User.php'));

        // Clean controllers directory from Http/Controllers
        $files->cleanDirectory(app_path('Http/Controllers'));

        // Clean app Exceptions
        $files->cleanDirectory(app_path('Exceptions'));

        // Remove public assets
        $files->deleteDirectory(public_path('css'));
        $files->deleteDirectory(public_path('js'));

        // Clean Assets
        $files->deleteDirectory(resource_path('assets'));

        // Clean views
        $files->cleanDirectory(resource_path('views'));

        // Clean database factories
        $files->cleanDirectory(database_path('factories'));

        // Clean database migrations
        $files->cleanDirectory(database_path('migrations'));

        // Clear all base laravel routes
        $files->put(base_path('routes/api.php'), "<?php \n");
        $files->put(base_path('routes/channels.php'), "<?php \n");
        $files->put(base_path('routes/console.php'), "<?php \n");
        $files->put(base_path('routes/web.php'), "<?php \n");

        $files->delete(base_path('webpack.mix.js'));
        $files->delete(base_path('package.json'));

        $files->copy(base_path('vendor/weareunite/unisys-api/bitbucket-pipelines.yml'), base_path('bitbucket-pipelines.yml'));
        $files->copy(base_path('vendor/weareunite/unisys-api/.push-to'), base_path('.push-to'));
        $files->copy(base_path('vendor/weareunite/unisys-api/deploy.sh'), base_path('deploy.sh'));
    }
}