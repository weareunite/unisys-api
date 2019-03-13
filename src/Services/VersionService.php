<?php

namespace Unite\UnisysApi\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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

    public function getPackageVersions(string $package)
    {
        $process = new Process([ 'composer', 'show', '--latest', $package ]);
        $process->run();

        if ($process->isSuccessful()) {
            preg_match_all('/(versions|latest)\s+:\s+(.*)/', $process->getOutput(), $versions);

            $current = str_replace([ '*', ' ' ], '', $versions[2][0]);
            $latest = $versions[2][1];

            $isLatest = ($current === $latest);

            return compact('current', 'latest', 'isLatest');
        } else {
            throw new ProcessFailedException($process);
        }
    }

    public function updatePackage(string $package, string $version = null)
    {
        $process = new Process(['rm', '-rf', $package]);
        $process->setWorkingDirectory(base_path('vendor'));
        $process->run();

        if ($version) {
            $cmd = [ 'composer', 'require', $package . ':' . $version ];
        } else {
            $cmd = [ 'composer', 'update', '-n', $package ];
        }

        $process = new Process($cmd);
        $process->setTimeout(3600);
//        $process->setIdleTimeout(3600);
        $process->run();

        return $process->getOutput();
    }

    public function getCurrentInstalledVersion(string $package)
    : string
    {
        $process = new Process([ 'composer', 'show', '--format=json' ]);
        $process->run();

        $package = collect(json_decode($process->getOutput())->installed)->where('name', '=', $package)->first();

        return $package->version;
    }
}