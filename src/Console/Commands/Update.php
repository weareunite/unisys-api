<?php

namespace Unite\UnisysApi\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Unite\UnisysApi\Services\VersionService;

class Update extends Command
{
    protected $signature = 'unisys-api:update {package : Name of package for update in weareunite family (weareunite/*)}';

    protected $description = 'Update package within weareunite family (weareunite/*)';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(VersionService $versionService)
    {
        $package = 'weareunite/' . $this->argument('package');

        $this->info('Checking for update ...');

        $current = $versionService->getPackageVersions($package);

        $this->table([ 'Current', 'Latest' ], [ [ $current['current'], $current['latest'] ] ]);

        if ($current['isLatest']) {
            $this->info('Package "' . $package . '" is up to date. current version is: ' . $current['current']);

            return true;
        }

        if ($current['version_compare'] !== -1) {
            $this->info('Package "' . $package . '" is up to date. current version is: ' . $current['current']);

            return true;
        }

        $this->info('updating "' . $package . '" ' . $current['current'] . ' -> ' . $current['latest']);

        $updateStatus = $versionService->updatePackage($package, $current['latest']);

        $afterUpdateVersion = $versionService->getCurrentInstalledVersion($package);

        $this->line($updateStatus);

        $this->info('Package "' . $package . '" was updated to version ' . $afterUpdateVersion);

        if ($afterUpdateVersion !== $current['latest']) {
            $this->error('Package is still out of date');
        }

        return true;
    }
}