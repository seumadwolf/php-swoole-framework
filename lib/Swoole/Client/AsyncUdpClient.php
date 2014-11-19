<?php
namespace Swoole\Client;

class AsyncUdpClient extends \Swoole\Client\AsyncClient
{
    public $requests;
    function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_UDP, SWOOLE_SOCK_ASYNC);
    }

    public function send($host, $port, $data, $callback, $timeout = 2)
    {
        $this->client->on("connect", function($cli) {
            echo "connected\n";
            $cli->send("hello world\n");
        });

        $this->client->on('close', function($cli){
            echo "closed\n";
        });

        $this->client->on('error', function($cli){
            echo "error\n";
        });

        $tmpFd = $this->client->sock . microtime(true) . rand(); // 伪fd
        $this->requests[$this->client->sock]['buffer'] = $data;
        $this->requests[$this->client->sock]['parse'] = $callback;
        $this->requests[$this->client->sock]['tmpFd'] = $tmpFd;

        $this->client->on("receive", function($cli, $data){
            //$tmpFd = $this->requests[$cli->sock]['tmpFd'];
            call_user_func_array($this->requests[$cli->sock]['parse'], array('r' => 0, 'data' => $data));
            unset($this->requests[$cli->sock]);
            $cli->close();
        });

        $this->client->connect($host, $port, $timeout);
    }
}