<?php

namespace App\Helpers;


class Storage
{
    /**
     * @return string[]
     */
    public static function getDirs(string $path): array
    {
        $result = [];
        if (is_dir($path)) {
            $di = new \DirectoryIterator($path);

            /** @var \DirectoryIterator $item */
            foreach ($di as $item) {
                if ($item->isDir() && !in_array($item->getFilename(), ['.', '..'])) {
                    $result[$item->getFilename()] = $item->getPathname();
                }
            }
        }
        return $result;
    }

    /**
     * @return string[]
     */
    public static function getFiles(string $path, ?string $ext = null): array
    {
        $result = [];
        if (is_dir($path)) {
            $di = new \DirectoryIterator($path);
            /** @var \DirectoryIterator $item */
            foreach ($di as $item) {
                if ($item->isFile()) {
                    if (!$ext || strtolower($ext) === strtolower($item->getExtension())) {
                        $result[] = $item->getPathname();
                    }
                }
            }
        }
        return $result;
    }

    public static function size($dir): int
    {
        $size = 0;
        if (is_file($dir)) {
            $size += filesize($dir);
        } else {
            foreach (self::getFiles($dir) as $file) {
                $size += filesize($file);
            }
            foreach (self::getDirs($dir) as $subdir) {
                $size += self::size($subdir);
            }
        }
        return $size;
    }

    public static function sizeAsString(string $path): string
    {
        return self::formatBytes(self::size($path));
    }

    public static function modifyPathSlashes(string $path): string
    {
        if (strpos($path,'/') === 0) {
            return str_replace('\\','/',$path);
        } else {
            return str_replace('/','\\',$path);
        }
    }

    public static function formatBytes($bytes, $precision = 2): string
    {
        $units  = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes  = max($bytes, 0);
        $pow    = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow    = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function clear(string $path)
    {
        $path = self::modifyPathSlashes($path);
        if (is_dir($path)) {
            if (substr($path, strlen($path) - 1, 1) != '/') {
                $path .= '/';
            }
            $dirItems = glob($path . '*', GLOB_MARK);
            foreach ($dirItems as $item) {
                $item = self::modifyPathSlashes($item);
                if (is_dir($item)) {
                    self::remove($item);
                } else {
                    unlink($item);
                }
            }
        }
    }

    public static function remove(string $path)
    {
        if (is_dir($path)) {
            self::clear($path);
            rmdir($path);
        } elseif (is_file($path)) {
            unlink($path);
        }
    }

    public static function checkOrCreate(string $path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public static function fileName(string $path): string
    {
        return basename($path);
    }
}
