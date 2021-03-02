<?php

error_reporting(0);
include('conn.php');
$acc = $_POST['account'];
$sql = 'SELECT * FROM customers WHERE cid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    goto ret;
} 
$sql = 'SELECT * FROM employees WHERE eid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    goto ret;
} 
$sql = 'SELECT * FROM suppliers WHERE sid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    goto ret;
} 
echo '用户名不存在';
ret:
$conn -> close();

?>