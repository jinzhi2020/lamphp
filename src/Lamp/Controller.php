<?php

namespace Lamp;

/**
 * Class Controller
 * @package Lamp
 */
class Controller
{

    /**
     * 构造方法
     */
    public function __construct () {

    }

    /**
     * 获取 IP
     * @return string
     */
    protected function getIp (): string {
        return $_SERVER['REMOTE_ADDR'] ?? '';
    }
}
