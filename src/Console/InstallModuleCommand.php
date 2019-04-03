<?php

namespace Unite\UnisysApi\Console;

use Illuminate\Console\Command;
use Unite\UnisysApi\Repositories\InstalledModuleRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

abstract class InstallModuleCommand extends Command implements InstallModuleCommandInterface
{
    private $isInstalled = false;

    protected $moduleName;

    protected $installedModuleRepository;

    protected $filesystem;

    public function __construct(InstalledModuleRepository $installedModuleRepository, Filesystem $files)
    {
        $this->installedModuleRepository = $installedModuleRepository;

        $this->signature = 'unisys-api:install:' . $this->moduleName;

        $this->description = 'Install [' . $this->moduleName . '] module to Unisys API';

        $this->filesystem = $files;

        parent::__construct();
    }
    /*
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing ...');

        $this->checkIfNotInstalled();

        if($this->isInstalled) {
            $this->info('This module was already installed');
            return;
        }

        $this->install();

        $this->addToInstalled();

        $this->info('UniSys module was installed');

    }

    protected abstract function install();

    private function checkIfNotInstalled()
    {
        if($this->installedModuleRepository->isModuleInstalled($this->moduleName)) {
            $this->isInstalled = true;
        }
    }

    private function addToInstalled()
    {
        $this->installedModuleRepository->create([
            'name' => $this->moduleName
        ]);
    }

    protected function strReplaceInFile($fileName, $find, $replaceWith)
    {
        $content = File::get($fileName);
        return File::put($fileName, str_replace($find, $replaceWith, $content));
    }
}