<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


require_once __DIR__ . '/../vendor/autoload.php';

use HaoTeam\HippoBuyer\Client;

$appKey = null;
$appSecret = null;

try {
    $Client = new Client($appKey, $appSecret);
    $response = $Client->request('App.Goods.List', ['page' => 1, 'limit' => 20]);
} catch (\Exception $e) {
    var_dump($e->getMessage());
    var_dump("\r\n");
    var_dump($e->getCode());
}
var_dump($response ?? null);
