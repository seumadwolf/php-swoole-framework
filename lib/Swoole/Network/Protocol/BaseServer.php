<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chalesi
 * Date: 14-2-27
 * Time: 下午8:08
 * To change this template use File | Settings | File Templates.
 */
namespace Swoole\Network\Protocol;

use Swoole;
class BaseServer extends Swoole\Network\Protocol implements Swoole\Server\Protocol
{
        public function onReceive($server,$clientId, $fromId, $data) {
        }
        public function onStart($serv, $workerId)
        {
        }
        public function onShutdown($serv, $workerId)
        {
        }
        public function onConnect($server, $fd, $fromId)
        {

        }
        public function onClose($server, $fd, $fromId)
        {

        }
        public function onTask($serv, $taskId, $fromId, $data)
        {

        }
        public function onFinish($serv, $taskId, $data)
        {

        }
        public function onRequest($request, $response) {}
}