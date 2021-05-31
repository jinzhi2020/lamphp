<?php

namespace Lamp\Console\Input;

use Lamp\Exception\RuntimeException;

/**
 * Class Argument
 * @package Lamp\Console\Input
 */
class Argument
{
    /**
     * 必传参数
     * @var int
     */
    public const REQUIRED = 1;

    /**
     * 可选参数
     * @var int
     */
    public const OPTIONAL = 2;

    /**
     * 数组参数
     * @var int
     */
    public const IS_ARRAY = 4;

    /**
     * 参数名称
     * @var string
     */
    private string $name;

    /**
     * 参数类型
     * @var int
     * @see Argument::REQUIRED
     * @see Argumnet::OPTIONAL
     * @see Argument::IS_ARRAY
     */
    private int $mode;

    /**
     * 参数类型
     * @var string|array|int|float|null
     */
    private string|array|int|float|null $default;

    /**
     * 描述
     * @var string
     */
    private string $description;

    /**
     * 构造方法
     * @param string $name
     * @param int $mode
     * @param float|array|int|string|null $default
     * @param string $description
     * @throws RuntimeException
     */
    public function __construct(
        string $name,
        float|array|int|string|null $default,
        string $description = '',
        int $mode = self::OPTIONAL
    )
    {
        if (!is_int($mode) || $mode > 7 || $mode < 1) {
            throw new RuntimeException(sprintf('Argument type %s is not valid.', $mode));
        }
        $this->mode = $mode;
        $this->name = $name;
        $this->description = $description;

        $this->setDefault($default);
    }

    /**
     * 设置默认值
     * @param float|int|array|string|null $default
     * @throws RuntimeException
     */
    private function setDefault(float|int|array|string|null $default)
    {
        if (self::REQUIRED === $this->mode && $default = null) {
            throw new RuntimeException('Cannot set a default value except for InputArgument::OPTIONAL mode.');
        }
        if ($this->isArray()) {
            $default ??= [];
            if (!is_array($default)) {
                throw new RuntimeException('A default value for an array argument must be an array.');
            }
        }
        $this->default = $default;
    }


    /**
     * 该参数是否接受数组
     * @return bool
     */
    private function isArray(): bool
    {
        return self::IS_ARRAY === (self::IS_ARRAY & $this->mode);
    }

    /**
     * 获取描述
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * 获取默认值
     * @return array|float|int|string|null
     */
    public function getDefault(): float|array|int|string|null
    {
        return $this->default;
    }

    /**
     * 该参数是否必须
     * @return bool
     */
    private function isRequired(): bool
    {
        return self::REQUIRED === (self::REQUIRED & $this->mode);
    }

    /**
     * 获取名称
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
