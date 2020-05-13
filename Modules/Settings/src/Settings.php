<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Unite\UnisysApi\Modules\Settings\Contracts\Settings as SettingsContract;
use Illuminate\Contracts\Foundation\Application;

class Settings implements SettingsContract
{
    const PATH_TO_ROUTES = __DIR__ . '/../routes/settings.php';

    /** @var string */
    protected $table;

    public function __construct(string $table = null)
    {
        $this->table = $table ?: self::generateTableName();
    }

    protected static function generateTableName()
    {
        $basename = class_basename(get_called_class());

        return Str::snake($basename);
    }

    public static function load(Application $application, string $table = null)
    {
        $class = get_called_class();

        /** @var self $instance */
        $instance = new $class($table);

        $application->singleton($class, function () use ($instance) {
            return $instance;
        });

        $table = $instance->getTable();

        $loadConfig = true;
        try {
            DB::connection()->getPdo();
        } catch (\Doctrine\DBAL\Driver\PDOException  $exception) {
            $loadConfig = false;
        }

        if ($loadConfig && Schema::hasTable($table)) {
            config([
                $table => $instance->getKeyValueFormat(),
            ]);
        }
    }

    protected function addToConfig(string $key, $value = null)
    {
        config([ $this->table . '.' . $key => $value ]);

        return $this;
    }

    public function getConfig()
    {
        return config($this->table);
    }

    public function getTable()
    : string
    {
        return $this->table;
    }

    public function getKeyValueFormat()
    : array
    {
        return DB::table($this->table)
            ->select([ 'key', 'value' ])
            ->get()
            ->keyBy('key')
            ->transform(function ($setting) {
                return $setting->value;
            })
            ->toArray();
    }

    public function updateByKey(string $key, $value = null)
    {
        DB::table($this->table)
            ->where('key', '=', $key)
            ->update([ 'value' => $value ]);

        $this->addToConfig($key, $value);

        return $this;
    }

    public function createNew(string $key, $value = null)
    {
        DB::table($this->table)
            ->insert([ 'key' => $key, 'value' => $value ]);

        $this->addToConfig($key, $value);

        return $this;
    }

    public function deleteByKey(string $key)
    {
        DB::table($this->table)
            ->where('key', '=', $key)
            ->delete();

        $this->addToConfig($key, null);

        return $this;
    }
}