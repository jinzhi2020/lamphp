<?php

namespace iphp;

use FilesystemIterator;
use Generator;

/**
 * Class FileSystem
 * @package iphp
 */
class FileSystem
{

    /**
     * 获取指定目录下的文件
     * @param string $path
     * @return array|Generator
     */
    public static function files(string $path): array|Generator
    {
        foreach (new FilesystemIterator($path) as $item) {
            yield $item->getPathName();
        }
    }

    /**
     * 删除文件
     * @param string $pathname
     */
    public static function delete(string $pathname): void
    {
        @unlink($pathname);
    }
}
