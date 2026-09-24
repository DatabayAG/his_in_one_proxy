<?php

namespace HisInOneProxy\Database;

class SchemaVersion
{
    public const INFO_FILE = 'cfg_update_info.php';
    public const RUNNING_FILE = 'cfg_update_running.php';

    public static function readApplied(?string $infoFile = null): ?int
    {
        $contents = self::readVersionFile($infoFile ?? self::INFO_FILE);
        if ($contents === null) {
            return null;
        }

        return (int) $contents;
    }

    public static function readRunning(?string $runningFile = null): int
    {
        $contents = self::readVersionFile($runningFile ?? self::RUNNING_FILE);
        if ($contents === null) {
            return 0;
        }

        return (int) $contents;
    }

    private static function readVersionFile(string $path): ?string
    {
        if (!is_file($path)) {
            return null;
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return null;
        }

        $contents = trim($contents);
        if ($contents === '') {
            return null;
        }

        return $contents;
    }
}
