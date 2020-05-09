<?php
/**
 * 单例操作数据库 写入
 */
class Sw
{
    private $_db = null;
    private static $_instance;

    //静态配置可拉出  设置成静态文件  或者常量
    public function __construct()
    {
        $this->_db = mysqli_connect('192.168.1.7', 'root', 'goodjob');
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //下列函数用于调整对象的克隆行为
    private function __clone() {}

    public function insert_one()
    {
        if (!mysqli_select_db($this->_db,'sakila'))
        {
            return false;
        }
        $time = time();
        $sql = "INSERT INTO sw_db (add_time) VALUES (".$time.")";
        $result = mysqli_query($this->_db, $sql);
        var_dump($result);
    }
}