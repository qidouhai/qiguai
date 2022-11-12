<?php
$servername = "localhost";
$username = "_qiguai";
$password = "123456";
$dbname = "qiguai";
 
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
// 检测连接
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
// 使用 sql 创建数据表

$sql = "CREATE TABLE urltablefirst (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(20) NOT NULL,
jsonurl VARCHAR(250) NOT NULL,
url VARCHAR(250) NOT NULL,
sign VARCHAR(100) NOT NULL,
type INT(20) NOT NULL,
times INT(20) NOT NULL
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000";
 
if (mysqli_query($conn, $sql)) {
    echo "数据表 urltablefirst 创建成功";
} else {
    echo "创建数据表错误: " . mysqli_error($conn);
}
 
mysqli_close($conn);
?>
