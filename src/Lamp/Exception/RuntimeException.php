<?php
declare(strict_types=1);

namespace Lamp\Exception;

use Exception;

/**
 * Class RuntimeException
 * @package Lamp
 */
class RuntimeException extends Exception
{
    protected $code = 1;
    protected $message = '系统错误';
}
