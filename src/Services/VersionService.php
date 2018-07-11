<?php

namespace Unite\UnisysApi\Services;

class VersionService extends AbstractService
{
    public static function getLastCommitDate()
    {
        return exec('git log -1 --format=%ai');
    }

    public static function getLastCommitAbbr()
    {
        return exec('git log -1 --format=%h');
    }

    public static function getLastTag()
    {
        $versionFile = base_path('version.txt');
        return file_exists($versionFile) ? file_get_contents($versionFile) : exec('git describe --tags');
    }
}