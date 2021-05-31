<?php

namespace Lamp\Tests;

use LAMP\Bean;
use PHPUnit\Framework\TestCase;

/**
 * Class BeanTest
 * @package Tests\Unit
 */
class BeanTest extends TestCase
{

    protected Bean $bean;

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
        $this->assertEquals('bob', $this->bean->getName());
    }

    /**
     * 测试输出数组
     */
    public function testToArray()
    {
        $arr = $this->bean->toArray();
        $this->assertIsArray($arr);
        $this->assertArrayHasKey('name', $arr);
        $this->assertArrayHasKey('age', $arr);
        $this->assertArrayNotHasKey('notExistsKey', $arr);
        $this->assertEquals('bob', $arr['name']);
        $this->assertEquals(15, $arr['age']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->bean = new class(['name' => 'bob', 'age' => 15, 'notExistsKey' => false]) extends Bean {
            protected string $name;
            protected int $age;
            protected static string $staticProp = 'static prop';

            public function getName()
            {
                return $this->name;
            }
        };
    }
}
