<?php

/*
 * CopyRight  : (C)2012-2099 HaoTeam Inc.
 * Document   : OrderService.php
 * Created on : 2024-1-4  14:41:39
 * Author     : Tiger <1192851302@qq.com>
 * Description: This is NOT a freeware, use is subject to license terms.
 *              这即使是一个免费软件,使用时也请遵守许可证条款,得到当时人书面许可.
 *              未经书面许可,不得翻版,翻版必究;版权归属 HaoTeam Inc;
 */

namespace HaoTeam\HippoBuyer\Core;

use HaoTeam\HippoBuyer\Http\HttpService;

/**
 * Description of OrderService
 *
 * @author tiger <1192851302@qq.com>
 * @datetime 2024-1-4  14:41:39
 */
class OrderService {

    protected $serviceUrl = '';

    /**
     * 
     * @author tiger <1192851302@qq.com>
     * @param string $serviceUrl
     */
    public function __construct(string $serviceUrl) {
        $this->serviceUrl = $serviceUrl;
    }

    /**
     * 
     * @author tiger <1192851302@qq.com>
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call($name, $arguments) {
        return HttpService::instance()->post($this->serviceUrl, $arguments[0]);
    }

    /**
     * 上传
     * @author tiger <1192851302@qq.com>
     * @param type $options
     * @return type
     */
    public function refund_upload_voucher($options) {
        return HttpService::instance()->post($this->serviceUrl, $options);
    }
}
