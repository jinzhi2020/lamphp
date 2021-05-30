<?php

namespace iphp\Exception;

use Exception;

/**
 * Class RuntimeException
 * @package iphp
 */
class RuntimeException extends Exception
{
    protected $code = 1;
    protected $message = '系统错误';
}
