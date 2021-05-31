<?php
declare(strict_types=1);

namespace Lamp;

use ReflectionClass;
use ReflectionProperty;

/**
 * Class Bean
 * @package App\Beans
 */
class Bean
{

    /**
     * Bean constructor.
     */
    public function __construct(?array $data)
    {
        if (!is_null($data)) {
            $this->arrayToBean($data);
        }
    }

    /**
     * 数组转为 Bean
     * @param array $data
     */
    private function arrayToBean(array $data)
    {
        $data = $this->filterNotExistsProps($data);
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * 过滤不存在的属性
     * @param array $data
     * @return array
     */
    private function filterNotExistsProps(array $data): array
    {
        $props = $this->allProperty();

        return array_filter($data, fn($key) => in_array($key, $props), ARRAY_FILTER_USE_KEY);
    }

    /**
     * 获取所有的属性
     * @return array
     */
    final public function allProperty(): array
    {
        $data = [];
        $clazz = new ReflectionClass($this);
        $protectedAndPublicProps = $clazz->getProperties(
            ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
        );
        foreach ($protectedAndPublicProps as $prop) {
            if ($prop->isStatic()) {
                continue;
            }
            array_push($data, $prop->getName());
        }

        return $data;
    }

    /**
     * 转换为数组
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $key => $value) {
            $props = $this->allProperty();
            in_array($key, $props) && $data[$key] = $value;
        }

        return $data;
    }
}
