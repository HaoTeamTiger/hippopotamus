<?php

/*
 * CopyRight  : (C)2012-2099 HaoTeam Inc.
 * Document   : GoodsService.php
 * Created on : 2024-1-4  14:39:06
 * Author     : Tiger <1192851302@qq.com>
 * Description: This is NOT a freeware, use is subject to license terms.
 *              这即使是一个免费软件,使用时也请遵守许可证条款,得到当时人书面许可.
 *              未经书面许可,不得翻版,翻版必究;版权归属 HaoTeam Inc;
 */

namespace HaoTeam\HippoBuyer\Core;

use HaoTeam\HippoBuyer\Http\HttpService;

/**
 * Description of GoodsService
 *
 * @author tiger <1192851302@qq.com>
 * @datetime 2024-1-4  14:39:06
 */
class GoodsService {

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
     * 商品列表
     * @author tiger <1192851302@qq.com>
     * @param type $options 参数数组
     * <p>categoryId    类目ID</p>
     * <p>keyword       关键字</p>
     * <p>activityId    选品规划id数组 来源于taglist</p>
     * <p>priceStart    价格区间开始</p>
     * <p>priceEnd      价格区间结束</p>
     * <p>shipInTime    发货时效</p>
     * <p>isYjdf        是否一件代发</p>
     * <p>isFreePostage 是否包邮</p>
     * @return int pageIndex 页码
     * @return int totalRecords 总条数
     * @return int sizePerPage 每页大小
     * @return array resultList 数据列表 
     * @throws Exception
     */
    public function list($options) {
        return HttpService::instance()->post($this->serviceUrl, $options);
    }
}
