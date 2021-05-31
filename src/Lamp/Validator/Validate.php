<?php
declare(strict_types=1);

namespace Lamp\Validator;

use Exception;

class Validate
{

    /**
     * 校验规则
     * @var array
     */
    protected array $rules = [];

    /**
     * 错误的消息
     * @var array
     */
    protected array $messages = [];

    /**
     * 遍历参数
     * @throws Exception
     */
    public function each(array $params): array
    {
        foreach ($this->rules as $property => $rules) {
            [$result, $rule] = $this->validate($property, $rules, $params);
            if (!$result) {
                throw new Exception($this->getMessage($property, $rule));
            }
        }

        return $params;
    }

    /**
     * 校验一个参数
     * @param string $property
     * @param $rules
     * @param array $params
     * @return array
     */
    private function validate(string $property, $rules, array &$params): array
    {
        foreach ($rules as $rule => $args) {
            $result = Rules::$rule($params, $property, $args);
            if ($result === false) {
                return [false, $rule];
            }
        }

        return [true, null];
    }

    /**
     * 获取错误消息
     * @param string $key
     * @param string $rule
     * @return string
     */
    private function getMessage(string $key, string $rule): string
    {
        return $this->messages[$key . '.' . $rule] ??
            $this->messages[$key] ??
            Rules::$defaultMessages[$rule];
    }

}
