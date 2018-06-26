<?php

namespace Unite\UnisysApi\Console\Commands\Install;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class UnisysApiInitializeEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unisys-api:init-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize database environment variables';


    /*
     * Execute the console command.
     */
    public function handle(Filesystem $files)
    {
        $this->info('Initializing database environment variables...');

        $this->getDbSettings();

        $this->info('Database environment variables initialized.');

        $this->setApplicationName();

        $this->updateApplicationSettings($files);
    }

    private function strReplaceInFile($fileName, $find, $replaceWith) {
        $content = File::get($fileName);
        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }

    /*
     * If default database name in env is present and interaction mode is on,
     * asks for database settings. Not provided values will not be overwritten.
     */
    private function getDbSettings()
    {
        if(env('DB_DATABASE') == 'homestead' && $this->input->isInteractive()) {

            $dbConnection = $this->choice('What database driver do you use?', ['mysql', 'pgsql'], 0);

            if(!empty($dbConnection)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_CONNECTION=mysql',
                    'DB_CONNECTION='.$dbConnection);
            }

            $dbHost = $this->anticipate('What is your database host?', ['localhost', '127.0.0.1'], 'localhost');

            if(!empty($dbHost)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_HOST=127.0.0.1',
                    'DB_HOST='.$dbHost);
            }

            $dbPort = $this->anticipate('What is your database port?', ['3306', '5432'], env('DB_DATABASE') == 'mysql' ? '3306' : '5432');

            if(!empty($dbPort)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_PORT=3306',
                    'DB_PORT='.$dbPort);
            }

            $DbDatabase = $this->ask('What is your database name?', 'homestead');

            if(!empty($DbDatabase)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_DATABASE=homestead',
                    'DB_DATABASE='.$DbDatabase);
            }

            $dbUsername = $this->ask('What is your database user name?', 'root');

            if(!empty($dbUsername)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_USERNAME=homestead',
                    'DB_USERNAME='.$dbUsername);
            }

            $dbPassword = $this->ask('What is your database user password?', 'root');

            if(!empty($dbPassword)) {
                $this->strReplaceInFile(base_path('.env'),
                    'DB_PASSWORD=secret',
                    'DB_PASSWORD='.$dbPassword);
            }
        }
    }

    /*
     * Change default application name from Laravel to Unisys API
     */
    private function setApplicationName()
    {
        if(env('APP_NAME') == 'Laravel') {
            $this->strReplaceInFile(base_path('.env'),
                'APP_NAME=Laravel',
                'APP_NAME="Unisys API"');

            $this->strReplaceInFile(base_path('.env.example'),
                'APP_NAME=Laravel',
                'APP_NAME="Unisys API"');
        }
    }

    private function updateApplicationSettings(Filesystem $files)
    {
        if(env('LOG_CHANNEL') !== 'daily') {
            $this->strReplaceInFile(base_path('.env'),
                'LOG_CHANNEL=stack',
                'LOG_CHANNEL=daily');
        }

        $files->append(base_path('.env'), '
AWS_KEY=null
AWS_SECRET=null
AWS_REGION=null
AWS_BUCKET=null
AWS_DOMAIN=null
SENTRY_DSN=null

WKHTMLTOPDF_BIN_PATH=/usr/local/bin/wkhtmltopdf
WKHTMLTOIMAGE_BIN_PATH=/usr/local/bin/wkhtmltoimage');
    }
}