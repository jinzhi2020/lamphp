<?php

namespace iphp\Orm;

/**
 * Class Scheme
 * @package iphp\Orm
 */
class Scheme
{
    /**
     * 表中的列
     * @var Column[]
     */
    private array $columns = [];

    /**
     * 构造方法
     * @param array $columns
     */
    public function __construct(array $columns = [])
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * 添加列
     * @param Column $column
     * @return Scheme
     */
    public function addColumn(Column $column): static
    {
        array_push($this->columns, $column);

        return $this;
    }

    /**
     * 获取所有的列名
     * @return array
     */
    public function getColumnNames(): array
    {
        $names = [];
        foreach ($this->columns as $column) {
            array_push($names, $column->getName());
        }

        return $names;
    }

    /**
     * 获取所有的列
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
