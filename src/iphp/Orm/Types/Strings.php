<?php

namespace iphp\Orm\Types;

use iphp\Exception\RuntimeException;

/**
 * Class Strings
 * @package iphp\Orm\Types
 */
class Strings extends Type
{

    /**
     * 字符串长度
     * @var int
     */
    protected int $length;

    /**
     * 构造方法
     * @throws RuntimeException
     */
    public function __construct(int $length = 1024)
    {
        parent::__construct('varchar');
        $this->length = $length;
    }
}
