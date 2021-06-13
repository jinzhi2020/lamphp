<?php
declare(strict_types=1);

namespace Lamp\Attributes\Bean;

use Attribute;

/**
 * Class ObjectArray
 * @package Lamp\Attributes\Bean
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class ObjectArray
{
    /**
     * ObjectArray constructor.
     * @param string $target
     * @param array $data
     */
    public function __construct(
        protected string $target,
        protected array $data = [])
    {
        // Not to do anythings.
    }

    /**
     * 加载数据
     * @param object $instance
     * @param string $property
     * @param array $data
     */
    public function load(object $instance, string $property, array $data)
    {
        $targetClazz = $this->target;
        foreach ($data as $datum) {
            $instance->$property[] = (new $targetClazz($datum));
        }
    }
}