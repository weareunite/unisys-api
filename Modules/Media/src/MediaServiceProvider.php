<?php

namespace Unite\UnisysApi\Modules\Media;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Media\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class MediaServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }

        $this->loadGraphQLFrom(__DIR__ . '/GraphQL/types.php', __DIR__ . '/GraphQL/schemas.php');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        app()->config["filesystems.disks.uploads"] = [
            'driver' => 'local',
            'root'   => public_path('uploads'),
            'visibility' => 'public',
        ];

        app()->config["filesystems.disks.protectedUploads"] = [
            'driver' => 'local',
            'root'   => storage_path('app/uploads'),
            'visibility' => 'private',
        ];
    }
}
