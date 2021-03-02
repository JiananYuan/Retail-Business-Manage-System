<?php
    include('conn.php');
    $op = $_POST['op'];
    $id = $_POST['id'];
    $id = "'" . $id . "'";
    $name = $_POST['name'];
    $name = "'" . $name . "'";
    $city = $_POST['city'];
    $city = "'" . $city . "'";
    $phone = $_POST['phone'];
    $phone = "'" . $phone . "'";
    $sql = '';
    if ($op == 'customer') {
        $sql = 'INSERT INTO customers (cid, cname, city) VALUES (' . $id . ', ' . $name . ', ' . $city . ')';
    }
    if ($op == 'employee') {
        $sql = 'INSERT INTO employees (eid, ename, city) VALUES (' . $id . ', ' . $name . ', ' . $city . ')';
    }
    if ($op == 'supplier') {
        $sql = 'INSERT INTO suppliers (sid, sname, city, telephone_no) VALUES (' . $id . ', ' . $name . ', ' . $city . ', ' . $phone . ')';
    }
    $rec = $conn -> query($sql);
    if ($rec) {
        echo '<script language="javascript">alert("注册成功");window.location.href="login_page.php"</script>';
    } else {
        echo '<script language="javascript">alert("注册失败");window.location.href="register_page.php"</script>';
    }
    $conn -> close();
?>