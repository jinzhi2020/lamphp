<?php

namespace iphp\Tools;

use function Symfony\Component\String\u;

/**
 * Class Strings
 * @package iphp\Tools
 */
class Strings
{

    /**
     * 转为蛇形字符串
     * @param string $str
     * @return string
     */
    public static function snake(string $str): string
    {
        return u($str)->snake();
    }
}
