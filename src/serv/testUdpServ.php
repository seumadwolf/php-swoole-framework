<?php

class testUdpServ extends Swoole\Network\Protocol\BaseServer{

    public function onReceive($server, $fd, $fromId, $data) {
        $this->server->send($fd, $data);
    }
}