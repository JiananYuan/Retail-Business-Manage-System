<?php
    session_start();
    error_reporting(0);
    header("Content-type:text/html;charset=utf-8");
    $acc = $_GET['acc'];
    if ($acc == "" || !isset($_SESSION['$acc']) || $_SESSION['$acc'] == false) {
        echo '<h1>没有权限访问</h1>';
        return ;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>购入产品</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        #main {
            width: 50%;
            margin-top: 50px;
        }
        #btn {
            margin-left: 70%;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <button type="button" class="btn btn-danger" id="btn">登出</button>
    <div id="main">
        <form action="add_product.php?acc=<?php echo $acc; ?>" method="POST"  enctype="multipart/form-data">
            <?php
                echo "<input='hidden' value=" . $acc . " name='acc'>";
            ?>
            <table class="table" style="margin-left: 45%;">
                <caption>购入产品</caption>
                <thead>
                <tr>
                    <th>产品编号</th>
                    <th>产品名</th>
                    <th>产品库存</th>
                    <th>产品阈值</th>
                    <th>产品原价</th>
                    <th>产品折扣</th>
                    <th>供应商号</th>
                    <th>图片描述</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" placeholder="pid" name="pid"></td>
                        <td><input type="text" class="form-control" placeholder="pname" name="pname"></td>
                        <td><input type="text" class="form-control" placeholder="qoh" name="qoh"></td>
                        <td><input type="text" class="form-control" placeholder="qoh_threshold" name="qoh_threshold"></td>
                        <td><input type="text" class="form-control" placeholder="original_price" name="original_price"></td>
                        <td><input type="text" class="form-control" placeholder="discnt_rate" name="discnt_rate"></td>
                        <td><input type="text" class="form-control" placeholder="sid" name="sid"></td>
                        <td><input type="file" class="form-control" name="pic" accept="image/png, image/jpeg, image/gif, image/jpg"></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-default btn-lg " style="margin-left: 90%;">确认</button>
        </form>
    </div>
        <script>
        $("#btn").click(function() {
           $.ajax({
               url: 'unset_session.php?acc=<?php echo $acc; ?>',
           })
           window.location.href='login_page.php';
        });
        </script>
</body>
</html>