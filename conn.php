<?php 
    $hostname = "localhost"; // 本地服务器
    $database = "ex4";       // 数据库名
    $username = "root";      // 数据库用户名
    $password = "";          // 数据库密码
    $conn = new mysqli($hostname, $username, $password, $database);  // 连接数据库
    header("Content-type:text/html;charset=utf-8");
?>
