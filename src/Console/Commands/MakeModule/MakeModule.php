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

    protected $basicName;

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
        $this->setModuleName($this->argument('name'));

        $this->createDirectories();

        $this->createFiles();

        exec('composer dump-autoload');

        $this->info($this->moduleName . ' module created successfully.');
    }

    protected function createDirectories()
    {
        $dirs = [
            '/src/GraphQL/Mutations',
            '/database/migrations',
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
            'src/DummyModuleServiceProvider.php.stub',
            'src/DummyModelRepository.php.stub',
            'src/DummyModel.php.stub',
            'src/GraphQL/types.php.stub',
            'src/GraphQL/DummyGraphQLType.php.stub',
            'src/GraphQL/schemas.php.stub',
            'src/GraphQL/ListQuery.php.stub',
            'src/GraphQL/DetailQuery.php.stub',
            'src/GraphQL/Mutations/CreateMutation.php.stub',
            'src/GraphQL/Mutations/DeleteMutation.php.stub',
            'src/GraphQL/Mutations/UpdateMutation.php.stub',
            'database/migrations/create_dummy_module_tables.php.stub'
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

        return $this->getModulePath() . '/' .$this->replaceDummyStrings($dummyName);
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
                'dummy_module',
                'dummyModules',
                'dummyModule',
                'DummyModel',
                'DummyGraphQLType',
            ],
            [
                $this->getNamespace($this->moduleName),
                $this->moduleName,
                Str::snake($this->moduleName),
                lcfirst($this->moduleName),
                lcfirst($this->basicName),
                $this->getModelClass(),
                $this->getGraphQlTypeClass(),
            ],
            $content
        );
    }

    protected function setModuleName(string $name)
    {
        $this->moduleName = $this->makePluralName($name);

        $this->basicName = $this->makeBasicName($name);
    }

    protected function getModulePath()
    {
        return $this->laravel['path'] . '/Modules/' . $this->moduleName;
    }

    protected function getModelClass()
    {
        return $this->basicName;
    }

    protected function getGraphQlTypeClass()
    {
        return $this->basicName . 'Type';
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

    protected function makePluralName(string $name)
    {
        return Str::plural($this->makeBasicName($name));
    }

    protected function makeBasicName(string $name)
    {
        return ucfirst(trim($name));
    }
}