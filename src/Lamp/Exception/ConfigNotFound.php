<?php

namespace Lamp\Exception;

use Exception;

/**
 * Class ConfigNotFound
 * @package Lamp\Exception
 */
class ConfigNotFound extends Exception
{
    protected $code = 2;
    protected $message = 'Config not found!';
}
