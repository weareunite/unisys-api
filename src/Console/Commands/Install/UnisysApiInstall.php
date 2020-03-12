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

        $this->call('migrate');

        $this->call('unisys-api:install:activityLogs');
        $this->call('unisys-api:install:categories');
        $this->call('unisys-api:install:company');
        $this->call('unisys-api:install:contacts');
        $this->call('unisys-api:install:errorReports');
        $this->call('unisys-api:install:graphql');
        $this->call('unisys-api:install:help');
        $this->call('unisys-api:install:invoice');
        $this->call('unisys-api:install:media');
        $this->call('unisys-api:install:permissions');
        $this->call('unisys-api:install:properties');
        $this->call('unisys-api:install:settings');
        $this->call('unisys-api:install:system');
        $this->call('unisys-api:install:tags');
        $this->call('unisys-api:install:users');

        $this->call('unisys:set-first-user');

        $this->call('passport:install', [ '--force' ]);

        $this->call('deploy:init');

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
        $this->installSpatieBackup();
        $this->installSpatieModelStatus();
        $this->installBarryvdhLaravelSnappy();
        $this->installMaatwebsiteExcel();
        $this->installUnisysApi();
    }

    protected function installSpatieBackup()
    {
        //Spatie Backup
        $this->call('vendor:publish', [
            '--provider' => "Spatie\\Backup\\BackupServiceProvider",
        ]);
    }

    protected function installSpatieModelStatus()
    {
        //Spatie model-status
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\ModelStatus\\ModelStatusServiceProvider',
            '--tag'      => 'migrations',
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\\ModelStatus\\ModelStatusServiceProvider',
            '--tag'      => 'config',
        ]);
    }

    protected function installBarryvdhLaravelSnappy()
    {
        //Barryvdh laravel-snappy
        $this->call('vendor:publish', [
            '--provider' => 'Barryvdh\\Snappy\\ServiceProvider',
        ]);
    }

    protected function installMaatwebsiteExcel()
    {
        //maatwebsite excel
        $this->call('vendor:publish', [
            '--provider' => "Maatwebsite\\Excel\\ExcelServiceProvider",
        ]);
    }

    protected function installUnisysApi()
    {
        //Unite unisys-api
        $this->call('vendor:publish', [
            '--provider' => "Unite\\UnisysApi\\UnisysApiServiceProvider",
        ]);
    }

    private function prepareLaravelApp(Filesystem $files)
    {
        $this->info('Preparing laravel app for unisys api ...');

        //change config/auth.php to use default guard to api
        $this->strReplaceInFile(config_path('auth.php'),
            "'guard' => 'web'",
            "'guard' => 'api'");

        //change config/auth.php to use api driver to passport
        $this->strReplaceInFile(config_path('auth.php'),
            "'driver' => 'token'",
            "'driver' => 'passport'");

        $files->copy(base_path('vendor/weareunite/unisys-api/bitbucket-pipelines.yml'), base_path('bitbucket-pipelines.yml'));
        $files->copy(base_path('vendor/weareunite/unisys-api/.env.testing'), base_path('.env.testing'));
    }
}