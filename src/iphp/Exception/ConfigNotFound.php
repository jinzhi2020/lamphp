<?php

namespace iphp\Exception;

use Exception;

/**
 * Class ConfigNotFound
 * @package iphp\Exception
 */
class ConfigNotFound extends Exception
{
    protected $code = 2;
    protected $message = 'Config not found!';
}
