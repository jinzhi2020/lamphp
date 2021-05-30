<?php

namespace iphp\Validator;

use iphp\Exception\RuntimeException;

/**
 * Class Rules
 * @package iphp
 */
class Rules
{

    public static array $defaultMessages = [
        'lengthBetween' => 'String length out to range!',
        'required' => 'Param required!',
        'call' => 'Validate not pass!',
    ];

    /**
     * 校验参数必填
     * @param array $params
     * @param string $key
     * @param bool $required
     * @return bool
     */
    public static function required(array $params, string $key, bool $required): bool
    {
        if ($required === true) {
            return isset($params[$key]);
        }

        return true;
    }

    /**
     * 设置默认值
     * @param array $params
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function defaultValue(array &$params, string $key, $value): bool
    {
        if (!isset($params[$key])) {
            $params[$key] = $value;
        }

        return true;
    }

    /**
     * 校验字符串长度
     * @param array $params
     * @param string $key
     * @param array $range
     * @return bool
     */
    public static function lengthBetween(array $params, string $key, array $range): bool
    {
        if (!isset($params[$key])) {
            return true;
        }
        $length = mb_strlen($params[$key]);
        [$min, $max] = $range;

        return ($length >= $min && $length <= $max);
    }

    /**
     * 校验整型
     * @param array $params
     * @param string $key
     * @return bool
     */
    public static function integer(array $params, string $key): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return filter_var($params[$key], FILTER_VALIDATE_INT);
    }

    /**
     * 判断是否存在于给定的数组
     * @param array $params
     * @param string $key
     * @param array $arr
     * @return bool
     */
    public static function inArray(array $params, string $key, array $arr): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return in_array($params[$key], $arr);
    }

    /**
     * 校验最大值
     * @param array $params
     * @param string $key
     * @param int $max
     * @return bool
     */
    public static function max(array $params, string $key, int $max): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return $params[$key] < $max;
    }

    /**
     * 转换为整型
     * @param array $params
     * @param string $key
     * @param bool|null $parsed
     * @return bool
     */
    public static function parseInt(array &$params, string $key, ?bool $parsed = true): bool
    {
        if (isset($params[$key]) && $parsed) {
            $params[$key] = (int)$params[$key];
        }

        return true;
    }

    /**
     * 校验数值返回
     * @param array $params
     * @param string $key
     * @param array $range
     * @return bool
     */
    public static function numberBetween(array $params, string $key, array $range): bool
    {
        if (!isset($params[$key])) {
            return true;
        }
        return ($params[$key] >= $range[0] && $params[$key] <= $range[1]);
    }

    /**
     * 校验中国手机号
     * @param array $params
     * @param string $key
     * @return bool
     */
    public static function chinaPhone(array $params, string $key): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return preg_match('/^1[3456789]\d{9}$/', $params[$key]);
    }

    /**
     * 校验 IP 地址
     * @param array $params
     * @param string $key
     * @return bool
     */
    public static function ip(array $params, string $key): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return filter_var($params[$key], FILTER_VALIDATE_IP);
    }

    /**
     * 校验网址
     * @param array $params
     * @param string $key
     * @return bool
     */
    public static function url(array $params, string $key): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return filter_var($params[$key], FILTER_VALIDATE_URL);
    }

    /**
     * 自定义验证规则
     * @param array $params
     * @param string $key
     * @param array $callable
     * @return bool
     */
    public static function call(array $params, string $key, array $callable): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return call_user_func($callable, $params, $key);
    }

    /**
     * 使用指定验证器验证
     * @param array $params
     * @param string $key
     * @param array $args
     * @return bool
     * @throws RuntimeException
     */
    public static function validator(array &$params, string $key, array $args): bool
    {
        $args['loop'] ??= false;
        if (!isset($params[$key])) {
            return true;
        }
        if (!class_exists($args['class'])) {
            throw new RuntimeException(sprintf('Validator class %s not defined!', $args['class']));
        }
        $validatorObject = new ($args['class'])();
        if (!in_array(Validate::class, class_parents($validatorObject))) {
            throw new RuntimeException(sprintf('Validator %s parent class must be Validator:class!', $args['class']));
        }
        if ($args['loop']) {
            // 支持循环校验
            foreach ($params[$key] as $k => $v) {
                if (!is_array($v)) {
                    return false;
                }
                $params[$key][$k] = $validatorObject->each($params[$key][$k]);
            }
        } else {
            $params[$key] = $validatorObject->each($params[$key]);
        }

        return true;
    }

    /**
     * 校验是否为空
     * @param array $params
     * @param string $key
     * @param bool $notEmpty
     * @return bool
     */
    public static function notEmpty(array $params, string $key, bool $notEmpty = true): bool
    {
        if (!isset($params[$key])) {
            return true;
        }

        return $notEmpty && !empty($params[$key]);
    }
}