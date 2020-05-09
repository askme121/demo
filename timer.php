<?php

$serv = new Swoole\Server("0.0.0.0", 9501);

$serv->set(array(
    'worker_num' =>2,    //worker process num
 ));

//创建自定义进程
$process = new Swoole\Process(function($process) use ($serv) {
    $serv->tick(2000, function(){
        echo "执行定时器任务 ".time()." \n";
    });
});

$serv->addProcess($process);

$serv->on('connect', function ($serv, $fd){
    echo "客户端 ".$fd."连接成功 \n";
});
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    echo "客户端 ".$fd."发来消息：".$data."\n";
    $serv->send($fd, 'Swoole已经介绍到您发送的消息: '.$data);
});
$serv->on('close', function ($serv, $fd) {
    echo "客户端 {$fd}关闭连接\n";
});

$serv->start();
