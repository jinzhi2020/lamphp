<?php

namespace LAMP\Tools;

use function Symfony\Component\String\u;

/**
 * Class Strings
 * @package LAMP\Tools
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
