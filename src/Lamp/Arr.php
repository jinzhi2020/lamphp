<?php

namespace Lamp;

/**
 * Class Arr
 * @package Lamp
 */
class Arr
{

    /**
     * 删除指定的多个 Key
     * @param array $arr
     * @param array $keys
     */
    public static function unset(array &$arr, array $keys): void
    {
        foreach ($keys as $key) {
            unset($arr[$key]);
        }
    }
}
