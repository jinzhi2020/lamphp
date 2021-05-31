<?php
declare(strict_types=1);

namespace Lamp\Orm\Types;

use Lamp\Exception\RuntimeException;

/**
 * Class Strings
 * @package Lamp\Orm\Types
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
