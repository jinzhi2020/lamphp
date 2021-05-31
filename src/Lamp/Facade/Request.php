<?php
declare(strict_types=1);

namespace Lamp\Facade;

use Lamp\Facade;
use Lamp\Request as ESShopRequest;

/**
 * Class Request
 * @package Lamp\facade
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