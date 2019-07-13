<?php

namespace Unite\UnisysApi\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'unisys-api:make:module {name : Name of module}';

    protected $description = 'Make new module in app directory';

    protected $files;

    protected $moduleName;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->moduleName = $this->getNameInput();

        $this->createDirectories();

        $this->createFiles();

        $this->info($this->getModuleName() . ' module created successfully.');
    }

    protected function createDirectories()
    {
        $dirs = [
            '/src/GraphQL/Mutations',
        ];

        foreach ($dirs as $dir) {
            $this->files->makeDirectory($this->getModulePath() . $dir, 0777, true, true);
        }
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Modules';
    }

    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')) . '\\' . $name
        );
    }

    protected function stubs()
    {
        return [
            'DummyModuleServiceProvider.php.stub',
            'DummyModuleRepository.php.stub',
            'DummyModel.php.stub',
            'GraphQL/types.php.stub',
            'GraphQL/DummyGraphQLType.php.stub',
            'GraphQL/schemas.php.stub',
            'GraphQL/ListQuery.php.stub',
            'GraphQL/DetailQuery.php.stub',
            'GraphQL/Mutations/CreateMutation.php.stub',
            'GraphQL/Mutations/DeleteMutation.php.stub',
            'GraphQL/Mutations/UpdateMutation.php.stub',
        ];
    }

    protected function createFiles()
    {
        foreach ($this->stubs() as $stub) {
            $this->files->put(
                $this->makeFileName($stub),
                $this->makeFileContent($stub));
        }
    }

    protected function makeFileName(string $dummyName)
    {
        $dummyName = str_replace('.stub', '', $dummyName);

        return $this->getModulePath() . '/src/' .$this->replaceDummyStrings($dummyName);
    }

    protected function makeFileContent(string $stub)
    {
        return $this->replaceDummyStrings($this->files->get(__DIR__ . '/stubs/' . $stub));
    }

    protected function replaceDummyStrings($content)
    {
        return str_replace(
            [
                'DummyNamespace',
                'DummyModule',
                'dummyModules',
                'dummyModule',
                'DummyModel',
                'DummyGraphQLType',
            ],
            [
                $this->getNamespace($this->moduleName),
                $this->getModuleName(),
                lcfirst($this->getModuleNamePlural()),
                lcfirst($this->getModuleName()),
                $this->getModelClass(),
                $this->getGraphQlTypeClass(),
            ],
            $content
        );
    }

    protected function getModuleName()
    {
        return $this->moduleName;
    }

    protected function getModulePath()
    {
        return $this->laravel['path'] . '/Modules/' . $this->getModuleName();
    }

    protected function getModuleNamePlural()
    {
        return Str::plural($this->moduleName);
    }

    protected function getModelClass()
    {
        return $this->moduleName;
    }

    protected function getGraphQlTypeClass()
    {
        return $this->moduleName . 'Type';
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return $this->qualifyClass($name);
    }

    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return ucfirst(trim($this->argument('name')));
    }
}