<?php
declare(strict_types=1);

namespace Lamp\Tools;

use function Symfony\Component\String\u;

/**
 * Class Strings
 * @package Lamp\Tools
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
        return u($str)->snake()->toString();
    }
}
