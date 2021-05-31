<?php

namespace Lamp\Orm\Types;

use Lamp\Exception\RuntimeException;

/**
 * Class Tinyint
 * @package Lamp\Orm\Types
 */
class Tinyint extends Type
{
    /**
     * 无符号
     * @var bool
     */
    protected bool $unsigned = false;

    /**
     * 构造方法
     * @param bool $unsigned
     * @throws RuntimeException
     */
    public function __construct(bool $unsigned = false)
    {
        parent::__construct('tinyint');
        $this->unsigned = false;
    }
}
