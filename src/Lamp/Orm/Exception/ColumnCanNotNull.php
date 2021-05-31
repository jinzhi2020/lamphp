<?php
declare(strict_types=1);

namespace Lamp\Orm\Exception;

use Exception;

/**
 * Class ColumnCanNotNull
 * @package Lamp\Orm\Exception
 */
class ColumnCanNotNull extends Exception
{
    protected $code = 1;
    protected $message = 'Column can not null!';
}