<?php

namespace Lamp\Orm;

use Lamp\Orm\Types\Type;

/**
 * Class Column
 * @package Lamp\Orm
 */
class Column
{
    /**
     * 列名
     * @var string
     */
    protected string $name;

    /**
     * 数据类型
     * @var Type
     */
    protected Type $type;

    /**
     * 备注
     * @var string
     */
    protected string $comment;

    /**
     * 默认值
     * @var string|int|float
     */
    protected string|int|float $default;

    /**
     * 是否为主键
     * @var bool
     */
    protected bool $isPrimaryKey = false;

    /**
     * 是否自增长
     * @var bool
     */
    protected bool $isAutoIncrement = false;

    /**
     * 是否为空
     * @var bool
     */
    protected bool $nullable = true;

    /**
     * 构造方法
     * @param string $name
     * @param bool $nullable
     * @param string $comment
     */
    public function __construct(string $name, bool $nullable = true, string $comment = '')
    {
        $this->setName($name);
        $this->setNullable($nullable);
        $this->setComment($comment);
    }

    /**
     * 设置备注
     * @param string $comment
     * @return Column
     */
    public function setComment(string $comment): Column
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * 设置字段类型
     * @param Type $type
     * @return Column
     */
    public function setType(Type $type): Column
    {
        $this->type = $type;

        return $this;
    }

    /**
     * 设置默认值
     * @param float|int|string $default
     * @return Column
     */
    public function setDefault(float|int|string $default): Column
    {
        $this->default = $default;

        return $this;
    }

    /**
     * 设置是否自增长
     * @param bool $isAutoIncrement
     * @return Column
     */
    public function setIsAutoIncrement(bool $isAutoIncrement = true): Column
    {
        $this->isAutoIncrement = $isAutoIncrement;

        return $this;
    }

    /**
     * 获取字段名
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 设置字段名称
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 获取是否为空
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * 设置是否为空
     * @param bool $nullable
     * @return Column
     */
    public function setNullable(bool $nullable = true): Column
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * 是否为主键
     * @return bool
     */
    public function isPrimaryKey(): bool
    {
        return $this->isPrimaryKey;
    }

    /**
     * 设置是否为主键
     * @param bool $isPrimaryKey
     * @return Column
     */
    public function setIsPrimaryKey(bool $isPrimaryKey): Column
    {
        $this->isPrimaryKey = $isPrimaryKey;

        return $this;
    }

}
