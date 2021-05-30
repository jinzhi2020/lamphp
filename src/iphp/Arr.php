<?php

namespace iphp;

/**
 * Class Arr
 * @package iphp
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
