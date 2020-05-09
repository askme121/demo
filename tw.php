<?php
date_default_timezone_set('Asia/Shanghai');

require_once 'sw.php';

class tw
{
    private static $_sw = null;

    public function __construct()
    {
        if (!isset(self::$_sw))
        {
            self::$_sw = new swoole_server('127.0.0.1', 9502);
		}
    }

    public function run()
    {
        self::$_sw->on('WorkerStart', array($this, 'onStart'));
        self::$_sw->on('Receive', array($this, 'onReceive'));
        self::$_sw->start();
	}

    public function onStart(swoole_server $_sw)
    {
        $_sw->tick(1000, function ($id)
        {
            $this->upsert();
        });
	}

    private function upsert()
    {
        $db_sw = Sw::getInstance();
        $db_sw->insert_one();
    }

    public function onReceive(swoole_server $_sw)
    {
        echo '1';
    }
}

$timer = new tw();
$timer->run();