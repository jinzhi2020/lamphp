<?php

namespace Lamp\Orm\Types;

use Lamp\Exception\RuntimeException;

/**
 * Class Type
 * @package App\Orm\Types
 */
class Type
{

    /**
     * 类型名称
     * @var string
     */
    protected string $name;

    /**
     * 支持的类型
     * @var array
     */
    protected array $supportedTypes = [
        'varchar', 'tinyint', 'int', 'decimal', 'datetime', 'bigint',
    ];

    /**
     * 构造方法
     * @throws RuntimeException
     */
    public function __construct(string $name)
    {
        if (!in_array($name, $this->supportedTypes)) {
            throw new RuntimeException('Type not supported!');
        }
        $this->name = $name;
    }


}
