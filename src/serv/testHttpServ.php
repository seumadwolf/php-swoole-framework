<?php
class testHttpServ extends Swoole\Network\Protocol\BaseServer{

    public function onRequest($request, $response) {
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }
}