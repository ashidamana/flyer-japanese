<?php

//禁用错误报告
//error_reporting(0);
//设置编码
header("Content-type: text/html; charset=utf-8");
//设置时区
date_default_timezone_set("PRC");
//引入数据库配置文件
//include_once '../../config/db_local.php';
include_once '../../config/db.php';
$config = $config['database'];
$date = date('Y-m-d');
//$date = '2018-04-05';
getDailySentence($date);

function getDailySentence($date) {
    //数据库操作
    $config = $GLOBALS['config'];
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];
    $table = $config['table'];


    $conn = getDBConnect($servername, $username, $password, $dbname);
    if ($conn) {
        //   查询
        $sql = "SELECT content FROM `" . $table . "` WHERE date='$date';";
        $res = findBySql($conn, $sql);
        if ($res) {
            $response = array(
                'status' => 'ok',
                'code' => '1',
                'data' => $res,
                'message' => 'get info successfully'
            );
        } else {
            $response = array(
                'status' => 'failed',
                'code' => '2',
                'data' => null,
                'message' => 'get info failed'
            );
        }
    } else {
        $response = array(
            'status' => 'failed',
            'code' => '3',
            'data' => null,
            'message' => 'get info failed' . 'connect db failed: ' . $conn->connect_error
        );
    }

    $conn->close();
    echo json_encode($response);
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
        // 输出数据
        while ($row = $result->fetch_assoc()) {
            $res = $row["content"];
        }
    } else {
        $res = false;
    }
    return $res;
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
