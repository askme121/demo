<?php
/*
 服务器可以同时被成千上万个客户端连接，$fd 就是客户端连接的唯一标识符
调用 $server->send() 方法向客户端连接发送数据，参数就是 $fd 客户端标识符
调用 $server->close() 方法可以强制关闭某个客户端连接
客户端可能会主动断开连接，此时会触发 onClose 事件回调
 */

$server = new Swoole\Server("127.0.0.1", 9503);

//监听连接进入事件
$server->on('connect', function ($server, $fd){
    echo "connection open: {$fd}\n";
});

//监听数据接收事件
$server->on('receive', function ($server, $fd, $reactor_id, $data) {
    $server->send($fd, "Swoole: {$data}");
    $server->close($fd);
});

//监听连接关闭事件
$server->on('close', function ($server, $fd) {
    echo "connection close: {$fd}\n";
});

//启动服务器
$server->start();