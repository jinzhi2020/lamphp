<?php
declare(strict_types=1);

namespace Lamp\Console;

/**
 * Class Table
 * @package Lamp\Console
 */
class Table
{

    /**
     * 左对齐
     * @var int
     */
    private const ALIGN_LEFT = 1;

    /**
     * 居中对齐
     * @var int
     */
    private const ALIGN_CENTER = 2;

    /**
     * 右对齐
     * @var int
     */
    private const ALIGN_RIGHT = 3;

    /**
     * 头部对齐方式
     * @var int
     */
    private int $headerAlign = self::ALIGN_LEFT;

    /**
     * 单元格对齐方式
     * @var int
     */
    private int $cellAlign = self::ALIGN_LEFT;

    /**
     * 头部数据
     * @var array
     */
    private array $headers = [];

    /**
     * 行数据
     * @var array
     */
    private array $rows = [];

    /**
     * 列宽
     * @var array
     */
    private array $cellWidth = [];

    /**
     * 表格样式
     * @var array
     */
    private array $styles = [
        'default'    => [
            'top'          => ['+', '-', '+', '+'],
            'cell'         => ['|', ' ', '|', '|'],
            'middle'       => ['+', '-', '+', '+'],
            'bottom'       => ['+', '-', '+', '+'],
            'cross-top'    => ['+', '-', '-', '+'],
            'cross-bottom' => ['+', '-', '-', '+'],
        ],
        'markdown'   => [
            'top'          => [' ', ' ', ' ', ' '],
            'cell'         => ['|', ' ', '|', '|'],
            'middle'       => ['|', '-', '|', '|'],
            'bottom'       => [' ', ' ', ' ', ' '],
            'cross-top'    => ['|', ' ', ' ', '|'],
            'cross-bottom' => ['|', ' ', ' ', '|'],
        ],
        'borderless' => [
            'top'          => ['=', '=', ' ', '='],
            'cell'         => [' ', ' ', ' ', ' '],
            'middle'       => ['=', '=', ' ', '='],
            'bottom'       => ['=', '=', ' ', '='],
            'cross-top'    => ['=', '=', ' ', '='],
            'cross-bottom' => ['=', '=', ' ', '='],
        ],
        'box'        => [
            'top'          => ['┌', '─', '┬', '┐'],
            'cell'         => ['│', ' ', '│', '│'],
            'middle'       => ['├', '─', '┼', '┤'],
            'bottom'       => ['└', '─', '┴', '┘'],
            'cross-top'    => ['├', '─', '┴', '┤'],
            'cross-bottom' => ['├', '─', '┬', '┤'],
        ],
        'box-double' => [
            'top'          => ['╔', '═', '╤', '╗'],
            'cell'         => ['║', ' ', '│', '║'],
            'middle'       => ['╠', '─', '╪', '╣'],
            'bottom'       => ['╚', '═', '╧', '╝'],
            'cross-top'    => ['╠', '═', '╧', '╣'],
            'cross-bottom' => ['╠', '═', '╤', '╣'],
        ],
    ];

    /**
     * 表格样式
     * @var string
     */
    private string $style = 'default';

    /**
     * 设置头部数据
     * @param array $headers
     * @param int $align
     */
    public function setHeader(array $headers, int $align = self::ALIGN_LEFT)
    {
        $this->headers = $headers;
        $this->headerAlign = $align;
        $this->setColumnsWidth($headers);
    }

    /**
     * 设置行数据
     * @param array $rows
     * @param int $align
     */
    public function setRows(array $rows, int $align = self::ALIGN_LEFT)
    {
        $this->rows = $rows;
        $this->cellAlign = $align;
        $this->setColumnsWidth($rows);
    }

    /**
     * 设置多行列宽
     * @param array $rows
     */
    private function setColumnsWidth(array $rows)
    {
        foreach ($rows as $row) {
            $this->setColumnWidth($row);
        }
    }

    /**
     * 设置全局的列对齐方式
     * @param int $align
     * @return Table
     */
    public function setCellAlign(int $align = self::ALIGN_LEFT): Table
    {
        $this->cellAlign = $align;

        return $this;
    }

    /**
     * 添加一行数据
     * @param array $row
     * @param bool $first
     */
    public function addRow(array $row, bool $first = false)
    {
        if ($first) {
            array_unshift($this->rows, $row);
        } else {
            $this->rows[] = $row;
        }
        $this->setColumnWidth($row);
    }

    /**
     * 设置样式
     * @param string $style
     * @return Table
     */
    public function setStyle(string $style = 'default'): Table
    {
        $this->style = $this->styles[$style] ?? 'default';

        return $this;
    }

    /**
     * 设置单行列宽
     * @param array $row
     */
    private function setColumnWidth(array $row)
    {
        if (is_array($row)) {
            // 遍历每一行每一列找出每一列中最大的列宽
            foreach ($row as $key => $value) {
                $width = mb_strwidth($value);
                if (!isset($this->cellWidth[$key]) || $width > $this->cellWidth[$key]) {
                    $this->cellWidth[$key] = $width;
                }
            }
        }
    }
}
