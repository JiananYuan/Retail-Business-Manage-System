<?php
session_start();
header("Content-type:text/html;charset=utf-8"); 
$cid = $_POST['cid'];
if($cid == "") {
    echo "<script language=javascript>window.confirm('请先登录');history.back(1);</script>";
    // echo $cid;
    // echo isset($_SESSION[$cid]);
    // echo $_SESSION[$cid];
    return ;
}
$pid = $_POST['pid'];
$eid = $_POST['eid'];
$eid = 'e1';
$qty = $_POST['qty'];
include('conn.php');
// 这里注意一下purchases表中的pur是没有自增的
$rec = $conn -> query("call customer_purchase($qty, '$cid', '$eid', '$pid')");
if ($rec == null) {
    echo "<script language=javascript>window.confirm('请先登录');history.back(1);</script>";
    // echo $cid;
    // echo isset($_SESSION[$cid]);
    // echo $_SESSION[$cid];
    return ;
}
echo "<script language=javascript>window.confirm('" . $rec->fetch_assoc()['msg'] . "');history.back(1);</script>";
$conn -> close();

?>