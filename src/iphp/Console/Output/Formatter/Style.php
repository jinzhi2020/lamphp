<?php

namespace iphp\Console\Output\Formatter;

/**
 * Class Style
 * @package iphp\Console\Output\Formatter
 */
class Style
{

    /**
     * 可用的前景色
     * @var array
     */
    protected static array $availableForegroundColors = [
        'black'   => ['set' => 30, 'unset' => 39],
        'red'     => ['set' => 31, 'unset' => 39],
        'green'   => ['set' => 32, 'unset' => 39],
        'yellow'  => ['set' => 33, 'unset' => 39],
        'blue'    => ['set' => 34, 'unset' => 39],
        'magenta' => ['set' => 35, 'unset' => 39],
        'cyan'    => ['set' => 36, 'unset' => 39],
        'white'   => ['set' => 37, 'unset' => 39],
    ];

    /**
     * 可用的背景色
     * @var array
     */
    protected static array $availableBackgroundColors = [
        'black'   => ['set' => 40, 'unset' => 49],
        'red'     => ['set' => 41, 'unset' => 49],
        'green'   => ['set' => 42, 'unset' => 49],
        'yellow'  => ['set' => 43, 'unset' => 49],
        'blue'    => ['set' => 44, 'unset' => 49],
        'magenta' => ['set' => 45, 'unset' => 49],
        'cyan'    => ['set' => 46, 'unset' => 49],
        'white'   => ['set' => 47, 'unset' => 49],
    ];

    /**
     * 前景色
     * @var array|null
     */
    private ?array $foreground = null;

    /**
     * 背景色
     * @var ?array|null
     */
    private ?array $background = null;

    /**
     * 初始化输出样式
     */
    public function __construct(?string $foreground = null, ?string $background = null)
    {
        !is_null($foreground) && $this->setForeground($foreground);
        !is_null($background) && $this->setBackground($background);
    }

    /**
     * 设置前景色
     * @param string|null $foreground
     */
    public function setForeground(?string $foreground)
    {
        $this->foreground = self::$availableForegroundColors[$foreground] ?? null;
    }

    /**
     * 设置背景色
     * @param ?string $background
     */
    public function setBackground(?string $background)
    {
        $this->background = self::$availableBackgroundColors[$background] ?? null;
    }

    /**
     * 应用样式
     * @param string $text
     * @return string
     */
    public function apply(string $text): string
    {
        $setCodes = $unsetCodes = [];
        if (!is_null($this->foreground)) {
            $setCodes[] = $this->foreground['set'];
            $unsetCodes[] = $this->foreground['unset'];
        }
        if (!is_null($this->background)) {
            $setCodes[] = $this->background['set'];
            $unsetCodes[] = $this->background['unset'];
        }

        return sprintf("\033[%sm%s\033[%sm",
            implode(';', $setCodes),
            $text,
            implode(';', $unsetCodes)
        );
    }
}
