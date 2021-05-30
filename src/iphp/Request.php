<?php

namespace iphp;

class Request
{

    /**
     * 获取输入参数
     * @param string|null $key
     * @return mixed
     */
    public function input(string $key = null): mixed
    {
        $params = array_merge($_GET, $_POST);
        // 兼容 json 传参
        $raw = file_get_contents('PHP://input');
        if (null !== $data = json_decode($raw, true)) {
            $params = array_merge($params, $data);
        }
        if (is_null($key) || empty($key)) {
            return $params;
        }

        return $params[$key] ?? null;
    }
}
