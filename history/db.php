<?php

/**
 * 数据库使用例子
 */
date_default_timezone_set("PRC");
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$flag = false;

// 使用 sql 创建数据表
$sql = "CREATE TABLE IF NOT EXISTS `jp_one`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(30) DEFAULT '' COMMENT '标题',
    `link` VARCHAR(60) DEFAULT '' COMMENT '源链接',
    `content` TINYTEXT COMMENT '内容',
    `date` DATE DEFAULT NULL COMMENT '日期',
    `create_time` DATETIME DEFAULT NULL COMMENT '创建时间',
    `update_time` DATETIME DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($conn->query($sql) === TRUE) {
    $flag = true;
} else {
    echo "创建数据表错误: " . $conn->error;
}

$title = "测试";
$link = "http://www.baidu.com/";
$content = "啊哈哈哈";
$date = date('Y-m-d');
$create_time = date('Y-m-d H:i:s');
$update_time = date('Y-m-d H:i:s');

if ($flag) {
    $sql = "INSERT INTO `jp_one`(title,link,content,date,create_time,update_time) VALUES('$title',"
            . "'$link','$content','$date','$create_time','$update_time');";

    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
