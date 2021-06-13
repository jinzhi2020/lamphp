<?php
declare(strict_types=1);

namespace Lamp;

use Lamp\Attributes\Bean\ObjectArray;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Class Bean
 * @package App\Beans
 */
class Bean
{

    /**
     * Bean constructor.
     * @throws ReflectionException
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
     * @throws ReflectionException
     */
    private function arrayToBean(array $data)
    {
        $data = $this->filterNotExistsProps($data);
        foreach ($data as $key => $value) {
            // 检查是否存在 ObjectArray 注解
            if (!$this->getAndSetAttribute(ObjectArray::class, $key, $value)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * 获取注解
     * @param string $name
     * @param string $property
     * @param mixed $value
     * @return bool
     * @throws ReflectionException
     */
    private function getAndSetAttribute(string $name, string $property, mixed $value): bool
    {
        $propertyRef = new ReflectionProperty(static::class, $property);
        $attribute = $propertyRef->getAttributes($name)[0] ?? null;
        if (!is_null($attribute)) {
            $attribute->newInstance()->load($this, $property, $value);
            return true;
        }

        return false;
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
