#!/usr/local/php/bin/php -q
<?php

// 定义根目录
define('BASEPATH', dirname(dirname(__FILE__)));

// 载入Swoole 框架
require_once BASEPATH . '/lib/Swoole/require.php';

// 定义网络层 UDP、TCP
$server = new \Swoole\Network\UdpServer();

// 加载配置文件
$server->loadConfig(__DIR__.'/testUdpServ.ini');

// 源码加载器
$server->setRequire(BASEPATH . '/src/require.php');

// 启动
$server->run();