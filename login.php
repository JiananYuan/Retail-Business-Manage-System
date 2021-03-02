<?php
session_start();
include('conn.php');
$acc = $_POST['account'];
$pwd = $_POST['password'];
if ($acc == "") {
    echo "<script language=javascript>window.alert('错误，用户名不能为空');history.back(1);</script>";
    goto ret;
}
if ($pwd == "") {
    echo "<script language=javascript>window.alert('错误，密码不能为空');history.back(1);</script>";
    goto ret;
}
$sql = 'SELECT * FROM customers WHERE cid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    $rec = $rec -> fetch_assoc();
    if ($pwd == $rec['cid']) {
        if(!isset($_SESSION['$acc'])){
            $_SESSION['$acc'] = true;
        }
        header('Location: ' . 'index.php?acc=' . $acc);
        // echo "<script language=javascript>window.location.replace('http://localhost/ex4/display_goods.php')</script>";
    } else {
        echo "<script language=javascript>window.alert('密码错误');history.back(1);</script>";
    }
    goto ret;
} 
$sql = 'SELECT * FROM employees WHERE eid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    $rec = $rec -> fetch_assoc();
    if ($pwd == $rec['eid']) {
        if(!isset($_SESSION['$acc'])){
            $_SESSION['$acc'] = true;
        }
        header('Location: ' . 'admin_board_1.php?acc=' . $acc);
        // echo "<script language=javascript>window.location.replace('http://localhost/ex4/display_goods.php')</script>";
    } else {
        echo "<script language=javascript>window.alert('密码错误');history.back(1);</script>";
    }
    goto ret;
} 
$sql = 'SELECT * FROM suppliers WHERE sid = "' . $acc . '"';
$rec = $conn -> query($sql);
if ($rec -> num_rows > 0) {
    $rec = $rec -> fetch_assoc();
    if ($pwd == $rec['sid']) {
        if(!isset($_SESSION['$acc'])){
            $_SESSION['$acc'] = true;
        }
        header('Location: ' . 'add_product_page.php?acc=' . $acc);
        // echo "<script language=javascript>window.location.replace('http://localhost/ex4/add_product_page.php')</script>";
    } else {
        echo "<script language=javascript>window.alert('密码错误');history.back(1);</script>";
    }
    goto ret;
} 
echo "<script language=javascript>window.alert('无登录id信息');history.back(1);</script>";

ret:
$conn -> close();

?>