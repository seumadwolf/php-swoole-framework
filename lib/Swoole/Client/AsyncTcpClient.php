<?php
namespace Swoole\Client;

class AsyncTcpClient
{
    static $timerEnable;
    static $timerSockets;

    public static function send($ip, $port, $data, $callback, $timeout = 0.2) {
        $client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        //设置事件回调函数
        $client->on("connect", function($cli) {
            $cli->send($cli->data);
        });
        $client->on("receive", function($cli, $data){
            //unset(self::$timerSockets[$cli->sock]);
            call_user_func_array($cli->callback, array('r' => 0, 'data' => $data));
        });
        $client->on("error", function($cli){
            call_user_func_array($cli->callback, array('r' => -1));
        });
        $client->on("close", function($cli){
        });
        $client->data = $data;
        $client->callback = $callback;
        $client->timeout = $timeout;
        $client->createTime = microtime(true);
        //发起网络连接
        $client->connect($ip, $port, $timeout);
        self::addTimeOut($client);
    }

    public static function addTimeOut($socket) {
        if (! self::$timerEnable) {
            self::$timerEnable = true;
            swoole_timer_add(100, function($interval) {
                foreach(self::$timerSockets as $k => $v)
                {
                    $timeNow = microtime(true);
                    if ($timeNow - $v->createTime > $v->timeout)
                    {
                        @$v->close();
                        unset(self::$timerSockets[$k]);
                    }
                }
            });
        }
        self::$timerSockets[$socket->sock] = $socket;
    }
}