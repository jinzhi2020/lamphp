<?php

namespace iphp\Orm\Types;

use iphp\Exception\RuntimeException;

/**
 * Class Integer
 * @package iphp\Orm\Types
 */
class Integer extends Type
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
        parent::__construct('int');
        $this->unsigned = $unsigned;
    }
}
