# [河马聚合供应链](http://cd.hmgyl.com.cn/)   

## 开发文档
专为PHPer准备的优雅而详细的开发文档，基本都能在文档找到你要的答案，请看:[开发文档](http://api.hmgyl.com.cn/docs.php)。  

## 快速安装

### composer一键安装

使用composer创建项目的命令，可实现一键安装。  

```bash
$ composer require haoteam/hippo-buyer-php-sdk
```
> 温馨提示：关于composer的使用，请参考[Composer 中文网 / Packagist 中国全量镜像](http://www.phpcomposer.com/)。  

## 使用

### 调用接口

例如，访问选品列表接口服务。  

```
http://api.hmgyl.com.cn/?s=App.Goods.List
``` 

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use HaoTeam\HippoBuyer\Client;

$appKey = null;
$appSecret = null;

try {
    $Client = new Client($appKey, $appSecret);
//    $response = $Client->request('App.Goods.List', ['page' => 1, 'limit' => 20]);
    $response = $Client->request('App.Goods.Detail', ['id' => 2361]);
} catch (\Exception $e) {
    var_dump($e->getMessage());
    var_dump("\r\n");
    var_dump($e->getCode());
}
var_dump($response ?? null);
```  

## 还有问题，怎么办？ 

通过微信联系我们 1192851302