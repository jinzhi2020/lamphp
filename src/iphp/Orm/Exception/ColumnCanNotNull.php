<?php

namespace iphp\Orm\Exception;

use Exception;

/**
 * Class ColumnCanNotNull
 * @package iphp\Orm\Exception
 */
class ColumnCanNotNull extends Exception
{
    protected $code = 1;
    protected $message = 'Column can not null!';
}