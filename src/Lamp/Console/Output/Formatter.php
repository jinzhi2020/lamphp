<?php

namespace Lamp\Console\Output;

use Lamp\Console\Output\Formatter\Stack as StyleStack;
use Lamp\Console\Output\Formatter\Style;

/**
 * Class Formatter
 * @package Lamp\Console\Output
 */
class Formatter
{

    /**
     * 样式栈
     * @var StyleStack
     */
    private StyleStack $styleStack;

    /**
     * 样式
     * @var array
     */
    private array $styles = [];

    /**
     * 初始化命令行输出格式
     */
    public function __construct()
    {
        $this->setStyle('error', new Style('white', 'red'));
        $this->setStyle('info', new Style('green'));
        $this->setStyle('comment', new Style('yellow'));
        $this->setStyle('question', new Style('black', 'cyan'));
        $this->setStyle('highlight', new Style('red'));
        $this->setStyle('warning', new Style('black', 'yellow'));

        $this->styleStack = new StyleStack();
    }

    /**
     * 设置样式
     * @param string $name
     * @param Style $style
     */
    public function setStyle(string $name, Style $style): void
    {
        $this->styles[strtolower($name)] = $style;
    }

    /**
     * 格式化消息
     * @param string $message
     * @return string
     */
    public function format(string $message): string
    {
        // 匹配标签
        $tagRegex = '[a-z][a-z0-9_=;-]*';
        $offset = 0;
        $output = '';
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#isx", $message, $matches, PREG_OFFSET_CAPTURE);
        // 匹配第 0 个标签，例如 <info> 和 </info>
        foreach ($matches[0] as $i => $match) {
            [$text, $position] = $match;
            // 消息中存在转义符号
            if (0 != $position && '\\' == $message[$position - 1]) {
                continue;
            }
            $output .= $this->applyCurrentStyle(substr($message, $offset, $position - $offset));
            $offset = $position + mb_strlen($text);
            if ($open = $text[1] != '/') {
                $tag = $matches[1][$i][0];
            } else {
                $tag = $matches[3][$i][0] ?? '';
            }
            if (!$open && !$tag) {
                $this->styleStack->pop();
            } elseif (false === $style = $this->createStyleFromString(strtolower($tag))) {
                $output .= $this->applyCurrentStyle($text);
            } elseif ($open) {
                $this->styleStack->push($style);
            } else {
                $this->styleStack->pop($style);
            }
        }
        $output .= $this->applyCurrentStyle(mb_substr($message, $offset));
        // 将转义的字符反转
        return str_replace('\\<', '<', $output);
    }

    /**
     * 从字符串中创建样式
     * @param string $tag
     * @return Style|null
     */
    private function createStyleFromString(string $tag): ?Style
    {
        // 预定样式
        if (isset($this->styles[$tag])) {
            return $this->styles[$tag];
        }

        return null;
    }

    /**
     * 应用当前样式
     * @param string $message
     * @return string
     */
    private function applyCurrentStyle(string $message): string
    {
        return mb_strlen($message) > 0 ? $this->styleStack->getCurrent()->apply($message) : $message;
    }
}
