<?php

namespace Unite\UnisysApi\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

abstract class InstallModuleCommand extends Command
{
    protected $moduleName;

    protected $fileSystem;

    public function __construct(Filesystem $files)
    {
        $this->signature = 'unisys-api:install:' . $this->moduleName;

        $this->description = 'Install [' . $this->moduleName . '] module to Unisys API';

        $this->fileSystem = $files;

        parent::__construct();
    }

    /*
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing module ' . $this->moduleName . ' ...');

        $this->install();

        $this->info('UniSys module ' . $this->moduleName . ' was installed');
    }

    protected abstract function install();

    protected function strReplaceInFile($fileName, $find, $replaceWith)
    {
        $content = File::get($fileName);

        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }
}