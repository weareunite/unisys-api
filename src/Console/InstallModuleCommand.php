<?php

namespace Unite\UnisysApi\Console;

use Illuminate\Console\Command;
use Unite\UnisysApi\Repositories\InstalledModuleRepository;
use Illuminate\Filesystem\Filesystem;

abstract class InstallModuleCommand extends Command implements InstallModuleCommandInterface
{
    protected $moduleName;

    protected $installedModuleRepository;

    protected $fileSystem;

    public function __construct(InstalledModuleRepository $installedModuleRepository, Filesystem $files)
    {
        $this->installedModuleRepository = $installedModuleRepository;

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
        $this->info('Installing module '. $this->moduleName .' ...');

        if($this->installedModuleRepository->isModuleInstalled($this->moduleName)) {
            $this->info('This module was already installed');
        } else {

            $this->install();

            $this->addToInstalled();

            $this->info('UniSys module '. $this->moduleName .' was installed');
        }
    }

    protected abstract function install();

    private function addToInstalled()
    {
        $this->installedModuleRepository->create([
            'name' => $this->moduleName
        ]);
    }
}