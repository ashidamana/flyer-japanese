<?php

/**
 * 爬取日语每日一句(单条)
 * @desc 每日一句内容来自http://bbs.tingroom.com/
 * @since 2018-04-18
 * @author Flyer
 */
//设置编码
header("Content-type: text/html; charset=utf-8");
//设置时区
date_default_timezone_set("PRC");
//引入simple_html_dom
include_once 'lib/simplehtmldom_1_5/simple_html_dom.php';
//引入数据库配置文件
//include_once 'config/db_local.php';
include_once 'config/db.php';

$config=$config['database'];

//获取昨天的日期，因为今天的内容不一定出来了，所以我们选择爬取昨天的数据
$yesterday = date("n.j", strtotime("-1 day"));
//获取今天的日期
$today = date('n.j');
$url = "http://bbs.tingroom.com/tag-%25E6%2597%25A5%25E8%25AF%25AD%25E6%25AF%258F%25E6%2597%25A5%25E4%25B8%2580%25E5%258F%25A5.html";

getDailySentence($yesterday, $today, $url);

/**
 * 获取并保存每日一句
 */
function getDailySentence($yesterday, $today, $url) {
//获取HTML DOM对象
    $html = file_get_html($url);
    $title = "";
    $link = "http://bbs.tingroom.com/";
// 找到昨天的每日一句，拿到标题和链接
    foreach ($html->find('a[href^=thread]') as $element) {
        if (strpos($element->innertext, $yesterday)) {
            $title.=str_replace($yesterday, $today, $element->innertext);
            $link.=$element->href;
//        条件达成，终止循环
            break;
        }
    }
//    echo "title:" . $title . '<br>';
//    echo "link:" . $link . '<br>';
//每日一句详细内容获取
    $html = file_get_html($link);
    $str = $html->find('td[class=t_msgfont]', 0);
//去掉j广告
    $content = trim(strip_tags($str, "<br>"));
//    echo $content . '<br><br>';
    saveDailySentence($title, $link, $content);
}

/**
 * 保存每日一句
 */
function saveDailySentence($title, $link, $content) {
    //数据库操作
    $config=$GLOBALS['config'];
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];
    $table = $config['table'];
    
    $conn = getDBConnect($servername, $username, $password, $dbname);
    if ($conn) {
        $flag = false;
        // 使用 sql 创建数据表
        $sql = "CREATE TABLE IF NOT EXISTS `".$table."`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(60) DEFAULT '' COMMENT '标题',
    `link` VARCHAR(60) DEFAULT '' COMMENT '源链接',
    `content` TEXT COMMENT '内容',
    `date` DATE DEFAULT NULL COMMENT '日期',
    `create_time` DATETIME DEFAULT NULL COMMENT '创建时间',
    `update_time` DATETIME DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        if (createTable($conn, $sql)) {
            $flag = true;
        } else {
            echo "create table error: " . $conn->error;
        }
        $date = date('Y-m-d');
        $create_time = date('Y-m-d H:i:s');
        $update_time = date('Y-m-d H:i:s');
        if ($flag) {
            //   查询
            $sql = "SELECT id FROM `".$table."` WHERE date='$date';";
            if (findBySql($conn, $sql)) {
                echo $create_time . " daily sentence already existed.";
            } else {
                //    插入
                $sql = "INSERT INTO `".$table."`(title,link,content,date,create_time,update_time) VALUES('$title',"
                        . "'$link','$content','$date','$create_time','$update_time');";
                if (insertBySql($conn, $sql)) {
                    echo $create_time . " insert daily sentence successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        die("connect db failed: " . $conn->connect_error);
    }

    $conn->close();
}

/**
 * 获取数据库连接
 * @param type $servername
 * @param type $username
 * @param type $password
 * @param type $dbname
 * @return boolean|\mysqli
 */
function getDBConnect($servername, $username, $password, $dbname) {
// 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

// 检测连接
    if ($conn->connect_error) {
        return false;
    }
//    设置编码
    mysqli_query($conn, 'set names utf8');
    return $conn;
}

/**
 * 创建表
 * @param type $sql
 * @return boolean
 */
function createTable($conn, $sql) {
    if ($conn->query($sql) === TRUE) {
        return true;
    }
    return false;
}

/**
 * 查询表
 * @param type $sql
 * @param type $create_time
 * @return boolean
 */
function findBySql($conn, $sql) {
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

/**
 * 插入表
 * @param type $conn
 * @param type $sql
 */
function insertBySql($conn, $sql) {
    if ($conn->query($sql) === TRUE) {
        return true;
    }
    return false;
}
