<?php

/*
 * CopyRight  : (C)2012-2099 HaoTeam Inc.
 * Document   : Client.php
 * Created on : 2024-1-4  14:54:24
 * Author     : Tiger <1192851302@qq.com>
 * Description: This is NOT a freeware, use is subject to license terms.
 *              这即使是一个免费软件,使用时也请遵守许可证条款,得到当时人书面许可.
 *              未经书面许可,不得翻版,翻版必究;版权归属 HaoTeam Inc;
 */

namespace HaoTeam\HippoBuyer;

/**
 * Description of Client
 *
 * @author tiger <1192851302@qq.com>
 * @datetime 2024-1-4  14:54:24
 */
class Client {

    protected $appid = '4506292583a5ea8a4463';
    protected $appSecret = '6546b03fb5c14b78aac7a72f30971e402868fe04c82e9242e9881f9bea3eaf6d';
    protected $serviceUrl = 'http://api.supply.net/';

    /**
     * @author tiger <1192851302@qq.com>
     * @param string $appid
     * @param string $appSecret
     */
    public function __construct(string $appid = null, string $appSecret = null) {
        $this->appid = $appid ? $appid : $this->appid;
        $this->appSecret = $appSecret ? $appSecret : $this->appSecret;
    }

    /**
     * 签名
     * @author tiger <1192851302@qq.com>
     * @param array $params
     * @return type
     */
    public function sign(array $params) {
        ksort($params);
        $url_string = '';
        foreach ($params as $key => $value) {
            $url_string .= $key . '=' . $value . '&';
        }

        $sign = hash_hmac("sha1", substr($url_string, 0, -1), $this->appSecret, true);
        $signHexWithLowcase = bin2hex($sign);
        return strtoupper($signHexWithLowcase);
    }

    /**
     * 签名验证
     * @author tiger <1192851302@qq.com>
     * @param array $sign
     * @param array $params
     * @return bool
     */
    public function signVerify(string $sign, array $params) {
        $expectSign = $this->Sign($params);
        if ($expectSign == $sign) {
            return true;
        }
        return false;
    }

    /**
     * 网络请求
     * @author tiger <1192851302@qq.com>
     * @param type $url 服务地址 App.Order.Refund_upload_voucher
     * @param type $params
     * @return type
     */
    public function request($url, $params) {
        [$path, $service, $method] = explode('.', $url);
        try {
            $Service = str_replace("{service}", ucfirst($service), "\HaoTeam\HippoBuyer\Core\{service}Service");
            $params['s'] = $url;
            $params['appid'] = $this->appid;
            $params['sign'] = $this->sign($params);
            $response = (new $Service($this->serviceUrl))->{strtolower($method)}($params);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage(), $exc->getCode());
        }

        return $response;
    }
}
