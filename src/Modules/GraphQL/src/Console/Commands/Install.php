<?php

namespace Unite\UnisysApi\Modules\GraphQL\Console\Commands;

use Unite\UnisysApi\Console\InstallModuleCommand;

class Install extends InstallModuleCommand
{
    protected $moduleName = 'graphql';

    protected function install()
    {
        //Rebing graphql-laravel
        $this->call('vendor:publish', [
            '--provider' => "Rebing\\GraphQL\\GraphQLServiceProvider",
        ]);

        //Mll-lab laravel-graphql-playground
        $this->call('vendor:publish', [
            '--provider' => "MLL\\GraphQLPlayground\\GraphQLPlaygroundServiceProvider",
        ]);
    }
}