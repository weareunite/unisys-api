<?php

namespace Unite\UnisysApi\Console;

use Illuminate\Console\Command;
use Unite\UnisysApi\Models\InstalledModule;

abstract class InstallModuleCommand extends Command implements InstallModuleCommandInterface
{
    private $isInstalled = false;

    protected $moduleName;

    public function __construct()
    {
        $this->signature = 'unisys-api:install:' . $this->moduleName;

        $this->description = 'Install [' . $this->moduleName . '] module to Unisys API';

        parent::__construct();
    }
    /*
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing ...');

        $this->checkIfNotInstalled();

        if(!$this->isInstalled) {
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
        if(InstalledModule::where('name', '=', $this->moduleName)->exists()) {
            $this->isInstalled = true;
        }
    }

    private function addToInstalled()
    {
        InstalledModule::create([
            'name' => $this->moduleName
        ]);
    }
}