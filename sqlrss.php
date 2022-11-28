<?php
$servername = "localhost";
$username = "qiguai";
$password = "123456";
$dbname = "qiguai";
 
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
// 检测连接
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
// 使用 sql 创建数据表

$sql = "CREATE TABLE urltittle (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
sitename VARCHAR(50) NOT NULL,
sitedescription VARCHAR(250) NOT NULL,
siteurl VARCHAR(50) NOT NULL,
sitetype VARCHAR(20) NOT NULL,
updatatime  VARCHAR(20) NOT NULL,
lastBuildDate VARCHAR(50) NOT NULL,
tittle VARCHAR(250) NOT NULL,
description VARCHAR(250) NOT NULL,
link VARCHAR(250) NOT NULL,
pubDate VARCHAR(50) NOT NULL,
keywords INT(30) NOT NULL DEFAULT '0',
statue  INT(10) NOT NULL DEFAULT '0',
follow INT(10) NOT NULL DEFAULT '0',
helpful INT(20) NOT NULL DEFAULT '0'
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
 
if (mysqli_query($conn, $sql)) {
    echo "数据表 urltittle 创建成功";
} else {
    echo "创建数据表错误: " . mysqli_error($conn);
}
 
mysqli_close($conn);
?>
