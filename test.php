<?php
require 'vo/Member.php';

$mem = new Member();
$mem->mem_name = 'test';
$mem->mem_age = 100;
print_r($mem);


$arr = array("hi" => 5, "hello" => 10, "user" => array("name" => "jj"));
echo $arr["user"]["name"] . "\n";

class Car
{
    var $greet = "Hi!!", $price = 550;

    function cc($art)
    {
        return $art;
    }

    function greeting($name)
    {
        return $this->greet . $name . ",price:" . $this->price;
    }
}

$new_item = new Car(); // 新建實例
echo $new_item->cc("times" . "\n"); // 調用方法
echo $new_item->greeting("Jamie"); //調用方法 & 屬性
