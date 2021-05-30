<?php

namespace iphp;

use ArrayAccess;
use iphp\Exception\RuntimeException;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;

/**
 * Class Enum
 * @package iphp
 */
class Enum implements ArrayAccess
{

    private array $data = [];

    /**
     * 构造方法
     */
    public function __construct()
    {
        $reflection = new ReflectionClass(static::class);
        $this->data = $reflection->getConstants();
    }

    /**
     * 获取所有的常量名称
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * 返回指定的值是否存在
     * @param string $value
     * @return bool
     */
    #[Pure] public function exists(string $value): bool
    {
        return in_array($value, $this->values());
    }

    /**
     * 获取所有的值
     * @return array
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * 转换为数组
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * 判断常量是否存在
     * @param mixed $offset
     * @return mixed
     */
    public function offsetExists($offset): mixed
    {
        return $this->data[$offset];
    }

    /**
     * 获取指定常量
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->data[$offset];
    }

    /**
     * 设置常量不被允许
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @throws RuntimeException
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException('Enum Constant Can not set!');
    }

    /**
     * 删除常量不被允许
     * @param mixed $offset
     * @throws RuntimeException
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException('Enum Constant Can not unset!');
    }
}
