<?php
$client = new Swoole\Client(SWOOLE_SOCK_TCP);

$ret = $client->connect('127.0.0.1', 8082);
if (empty($ret))
{
    echo 'error';
}
else
{
    //发送消息
    $client->send('winner');
    //接收数据
    $data = $client->recv();
    var_dump($data);
    //关闭连接
    $client->close();
}