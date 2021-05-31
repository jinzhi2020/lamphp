<?php
declare(strict_types=1);

namespace Lamp\Cache\Drives;

use Doctrine\Common\Cache\Cache;

/**
 * Class FileSystemCache
 * @package Lamp\Cache\Drives
 */
class FileSystemCache implements Cache {

    public function __construct (protected string $dir) {
        $this->dir = $dir;
    }

    /**
     * 获取缓存
     * @param string $id
     * @return void
     */
    public function fetch ($id) {
        $path = $this->dir.md5($id).'.cache';
        if (!is_file($path)) {
            return null;
        }
        $raw = file_get_contents($path);
        $content = json_decode($raw, true);
        $meta = $content['meta'];
        // 检查是否已经过期
        if (!$this->timeout($path, $meta)) {
            return null;
        }

        return $content['data'] ?? null;
    }

    /**
     * 是否超时
     * @param string $path
     * @param array $meta
     * @return bool
     */
    private function timeout (string $path, array $meta): bool {
        // 如果生存时间为 0, 则表示永不过期
        if ($meta['lifeTime'] === 0) {
            return true;
        }
        if (time() > $meta['timestamp'] + $meta['lifeTime']) {
            unlink($path);
            return false;
        }

        return true;
    }

    /**
     * 判断指定的 Key 是否存在
     * @param string $id
     * @return bool
     */
    public function contains ($id): bool {
        $path = $this->dir . md5($id).'.cache';
        if (!is_file($path)) {
            return false;
        }
        $raw = file_get_contents($path);
        $content = json_decode($raw, true);

        return $this->timeout($path, $content['meta']);
    }

    /**
     * 缓存
     * @param string $id
     * @param mixed $data
     * @param int $lifeTime
     * @return void
     */
    public function save ($id, $data, $lifeTime = 0) {
        $file = $this->dir . md5($id).'.cache';
        if (!file_exists($file)) {
            touch($file);
        }
        file_put_contents($file, json_encode([
            'data' => $data,
            'meta' => [
                'lifeTime'  => $lifeTime,
                'timestamp' => time(),
            ],
        ]));
    }

    /**
     * 删除缓存
     * @param string $id
     * @return void
     */
    public function delete ($id): void {
        $file = $this->dir . md5($id).'.cache';
        unlink($file);
    }

    /**
     * 获取缓存的状态
     * @return void
     */
    public function getStats () {
        // TODO: Implement getStats() method.
    }
}
