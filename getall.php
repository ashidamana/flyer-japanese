<?php

/**
 * 爬取日语每日一句(全部)
 * @desc 每日一句内容来自http://bbs.tingroom.com/
 * @since 2018-04-19
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
$config = $config['database'];

//参数配置
//=====================================
$d0 = '2017-09-01';
//需要的日期加1
$d1 = $yesterday = date("Y-m-d", strtotime("+1 day"));
//总页数
$pageCount = 7;
//基础地址
$url = "http://bbs.tingroom.com/tag.php?name=日语每日一句&page=";

//=====================================
//执行批量任务
executeTasks($d0, $d1, $url, $pageCount);

//执行任务
//executeTask($d0, $d1, $url,7);
//执行爬取任务（批量）
function executeTasks($d0, $d1, $url, $pageCount) {
    for ($i = $pageCount; $i > 0; $i--) {
        executeTask($d0, $d1, $url, $i);
    }
}

//执行爬取任务（单个）
function executeTask($d0, $d1, $url, $page = 1) {
    //获取HTML DOM对象
    $url.=$page;
    $html = file_get_html($url);
    $base = "http://bbs.tingroom.com/";
// 找到昨天的每日一句，拿到标题和链接
    $data = $html->find('a[href^=thread]');
//    数组反转
    $data = array_reverse($data);
    foreach ($data as $element) {
        $link = $base . $element->href;
        $today = getToday($element->innertext);
        $tomorrow = getTomorrow($d0, $d1, $today);
        $title = str_replace($today, $tomorrow, $element->innertext);
//    echo $element->href . '-' . $element->innertext;
        //每日一句详细内容获取
        $html = @file_get_html($link);
        if ($html) {
            $str = $html->find('td[class=t_msgfont]', 0);
//去掉j广告
            $content = trim(strip_tags($str, "<br>"));
            $date = getMyDate($tomorrow);
            echo $date . '-' . $tomorrow . '\n';
//        排错
            if ($date != '1970-01-01') {
                saveDailySentence($title, $link, $content, $date);
            }
        } else {
            continue;
        }
    }
}

//echo getTomorrow($d0, $d1, $day);
//获取日期范围，便于获取昨天
function getDays($d0, $d1) {
    $_time = range(strtotime($d0), strtotime($d1), 24 * 60 * 60);

    $_time = array_map(create_function('$v', 'return date("n.j", $v);'), $_time);

    return $_time;
}

//获取指定日期范围内某日期的明天
function getTomorrow($d0, $d1, $day) {
    $days = getDays($d0, $d1);
    $key = array_search($day, $days, true);
    if ($key) {
        $key++;
        return $days[$key];
    }
    return false;
}

//获取今天
function getToday($title) {
    $reg = "#(\d+\.\d+)#i";
    $a = preg_match($reg, $title, $mc);
    return isset($mc[0]) ? $mc[0] : "";
}

//获取日期
function getMyDate($day) {
    $days = explode('.', $day);
    $year = 2018;
    $now = date('n');
    if ($days[0] > $now) {
        $year = 2017;
    }
    $date = date('Y-m-d', strtotime($year . '-' . $days[0] . '-' . $days[1]));
    return $date;
}

/**
 * 保存每日一句
 */
function saveDailySentence($title, $link, $content, $date) {
    //数据库操作
    $config = $GLOBALS['config'];
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];
    $table = $config['table'];

    $conn = getDBConnect($servername, $username, $password, $dbname);
    if ($conn) {
        $flag = false;
        // 使用 sql 创建数据表
        $sql = "CREATE TABLE IF NOT EXISTS `" . $table . "`(
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
        $create_time = date('Y-m-d H:i:s');
        $update_time = date('Y-m-d H:i:s');
        if ($flag) {
            //   查询
            $sql = "SELECT id FROM `" . $table . "` WHERE date='$date';";
            if (findBySql($conn, $sql)) {
                echo $create_time . " daily sentence already existed.\n";
            } else {
                //    插入
                $sql = "INSERT INTO `" . $table . "`(title,link,content,date,create_time,update_time) VALUES('$title',"
                        . "'$link','$content','$date','$create_time','$update_time');";
                if (insertBySql($conn, $sql)) {
                    echo $create_time . " insert daily sentence successfully.\n";
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
