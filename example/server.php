<?php
$serv = new Swoole\Server('127.0.0.1', 8082);
$serv->set([
    'worker_num' => 1, //工作进程
    'task_worker_num' => 3, //异步task工作进程
]);

$serv->on('receive', function($serv, $fd, $from_id, $data){
    var_dump($data);
    $task_id = $serv->task($data);
    echo "begin id=$task_id".PHP_EOL;
    //响应客户端
    $serv->send($fd, "发送成功");
});

$serv->on('task', function ($serv, $task_id, $from_id, $data){
    $str = "receive [id=$task_id]";
    //执行业务
    for ($i = 0; $i < 500; $i++){
        echo $str.'send'.$i.'success'.PHP_EOL;
    }
    $serv->finish('task执行完毕');
});

$serv->on('finish', function ($serv, $task_id, $data){
    echo "success [id=$task_id]".PHP_EOL;
});

$serv->start();