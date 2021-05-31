<?php
declare(strict_types=1);

namespace Lamp\Console\Input;

use InvalidArgumentException;

/**
 * Class Option
 * @package Lamp\Console\Input
 */
class Option
{

    /**
     * 无需传值
     * @var int
     */
    public const VALUE_NONE = 1;

    /**
     * 必须传值
     * @var int
     */
    public const VALUE_REQUIRED = 2;

    /**
     * 可选传值
     * @var int
     */
    public const VALUE_OPTIONAL = 4;

    /**
     * 数组传值
     * @var int
     */
    public const VALUE_IS_ARRAY = 8;

    /**
     * 选项名称
     * @var string
     */
    private string $name;

    /**
     * 选项短名称
     * @var string
     */
    private string $shortcut;

    /**
     * 选项类型
     * @var int
     */
    private int $mode;

    /**
     * 选项默认值
     * @var int|float|string|array|null
     */
    private int|float|string|array|null $default;

    /**
     * 选项描述
     * @var string
     */
    private string $description;

    /**
     * 构造方法
     */
    public function __construct(
        string $name, ?string $shortcut = null, int $mode = self::VALUE_NONE, string $description = '', mixed $default = null
    )
    {
        if (empty($name)) {
            throw new InvalidArgumentException('An option name cannot be empty!');
        }
        if (str_starts_with($name, '--')) {
            $name = substr($name, 2);
        }
        if (empty($name)) {
            throw new InvalidArgumentException('An option name can be empty!');
        }
        if (!is_int($mode) || $mode < 1 || $mode > 15) {
            throw new InvalidArgumentException(sprintf('Option mode %s is invalid!', $mode));
        }
        $this->name = $name;
        $this->mode = $mode;
        $this->description = $description;
        $this->setDefaultValue($default);
    }

    /**
     * 设置默认值
     * @param mixed $default
     */
    private function setDefaultValue(mixed $default)
    {
        $this->default = $default;
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
