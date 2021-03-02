<?php
session_start();
$acc = $_GET['acc'];
$msg = "";
// 允许上传的图片后缀
include('conn.php');
header("Content-type:text/html;charset=utf-8");
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["pic"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["pic"]["type"] == "image/gif")
|| ($_FILES["pic"]["type"] == "image/jpeg")
|| ($_FILES["pic"]["type"] == "image/jpg")
|| ($_FILES["pic"]["type"] == "image/pjpeg")
|| ($_FILES["pic"]["type"] == "image/x-png")
|| ($_FILES["pic"]["type"] == "image/png"))
&& ($_FILES["pic"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["pic"]["error"] > 0)
    {
        $msg = "错误：: " . $_FILES["pic"]["error"] . "<br>";
    }
    else
    {
        $msg = "上传文件名: " . $_FILES["pic"]["name"] . "  ";
        $msg = $msg . "文件类型: " . $_FILES["pic"]["type"] . "  ";
        $msg = $msg . "文件大小: " . ($_FILES["pic"]["size"] / 1024) . " kB  ";
        $msg = $msg . "文件临时存储的位置: " . $_FILES["pic"]["tmp_name"] . "  ";
        
        // 判断当前目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("assets/" . $_FILES["pic"]["name"]))
        {
            $msg = $msg . $_FILES["pic"]["name"] . " 文件已经存在。 ";
        }
        else
        {
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($_FILES["pic"]["tmp_name"], "assets/" . $_FILES["pic"]["name"]);
            $msg = $msg . "文件存储在: " . "assets/" . $_FILES["pic"]["name"];
            $sql = "INSERT INTO picurl(pid, src) VALUES ('$_POST[pid]', 'assets/" . $_FILES['pic']['name'] . "')";
            $conn -> query($sql);
        }
    }
}
else
{
    $msg = "非法的文件格式";
}
$pid = $_POST['pid'];
$pname = $_POST['pname'];
$qoh = $_POST['qoh'];
$qoh_threshold = $_POST['qoh_threshold'];
$original_price = $_POST['original_price'];
$discnt_rate = $_POST['discnt_rate'];
$sid  =$_POST['sid'];
$sql = "call add_products('$pid', '$pname', $qoh, $qoh_threshold, $original_price, $discnt_rate, '$sid')";
$conn -> query($sql);
$conn -> close();
echo "<script language=javascript>window.alert('" . $msg . "');window.location.href='add_product_page.php?acc=" . $acc . "';</script>";

?>