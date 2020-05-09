<?php
class pub
{
    public $redis;

    public function  __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function cctv()
    {
        $msg = '';
        $rel = $this->redis->publish('sixstar:cctv', $msg);
        var_dump($rel);
    }

    public function swoole()
    {
        $msg = 'swoole是一个高性能扩展';
        $rel = $this->redis->publish('sixstar:swoole', $msg);
        var_dump($rel);
    }
}