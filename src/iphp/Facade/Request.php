<?php

namespace iphp\Facade;

use iphp\Facade;
use iphp\Request as ESShopRequest;

/**
 * Class Request
 * @package iphp\facade
 *
 * @method static mixed input(?string $key = null)
 */
class Request extends Facade
{


    /**
     * 获取当前 Facade 对应类名
     * @access protected
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return ESShopRequest::class;
    }
}