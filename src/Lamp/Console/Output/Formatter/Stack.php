<?php

namespace Lamp\Console\Output\Formatter;

use JetBrains\PhpStorm\Pure;

/**
 * Class Stack
 * @package Lamp\Console\Output\Formatter
 */
class Stack
{

    /**
     * 样式
     * @var Style[]
     */
    private array $styles = [];

    /**
     * 空样式
     * @var Style|null
     */
    private ?Style $emptyStyle;

    /**
     * 构造方法
     */
    public function __construct(?Style $emptyStyle = null)
    {
        $this->emptyStyle = $emptyStyle ?? new Style();
        $this->reset();
    }

    /**
     * 重置栈
     */
    public function reset()
    {
        $this->styles = [];
    }

    /**
     * 获取当前的样式
     * @return Style
     */
    public function getCurrent(): Style
    {
        if ($this->empty()) {
            return $this->emptyStyle;
        }

        return $this->styles[count($this->styles) - 1];
    }

    /**
     * 推入样式
     * @param Style $style
     */
    public function push(Style $style): void
    {
        array_push($this->styles, $style);
    }

    /**
     * 推出样式
     * @param Style|null $style
     * @return Style
     */
    public function pop(?Style $style = null): Style
    {
        if ($this->empty()) {
            return $this->emptyStyle;
        }

        return array_pop($this->styles);
    }

    /**
     * 返回栈是否为空
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->styles);
    }
}
