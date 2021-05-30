<?php

namespace iphp\Orm\Types;

use iphp\Exception\RuntimeException;

/**
 * Class Bigint
 * @package iphp\Orm\Types
 */
class Bigint extends Type
{
    /**
     * 是否无符号
     * @var bool
     */
    protected bool $unsigned = false;

    /**
     * 构造函数
     * @param bool $unsigned
     * @throws RuntimeException
     */
    public function __construct(bool $unsigned = false)
    {
        parent::__construct('bigint');
        $this->unsigned = $unsigned;
    }
}
