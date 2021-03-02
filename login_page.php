<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>欢迎登录零售商城</title>
    <style>
        html, body {
            height: 99%;
            width: 99%;
        }
        * {
            padding: 0;
            margin: 0;
        }
        #main {
            text-align: center;
            /* background-image: linear-gradient(to right,#fbc2eb,#a6c1ee); */
            position:absolute;
            top:60%;
            left:50%;
            transform: translate(-50%, -50%);
        }
        #login_face {
            height: 400px;
            width: 500px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .userinfo {
            border: 0;
            border-bottom: 1px solid rgb(128,125,125);
            outline: none;
            height: 40px;
            background-color: snow;
            padding-left: 5px;
            line-height: 40px;
        }
        .btn {
            background-image: linear-gradient(to right,#a6c1ee,#fbc2eb);
            border: 0;
            outline: none;
            width: 120px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-size: 16px;
        }
        span {
            font-size: 14px;
        }
        a {
            text-decoration: none;
            color: purple;
            font-size: 14px;
        }
        #hint {
            color: red;
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="myCarousel" class="carousel slide" style="position: relative; margin-left: 2%;">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="assets/huawei_mate_x_1.jpg" alt="First slide" height="100%" width="100%" style="opacity: 0.7;">
            </div>
            <div class="item">
                <img src="assets/O1CN01ZE160B1coN60zu5PH_!!2634283647.jpg" alt="Second slide" height="100%" width="100%"  style="opacity: 0.5;">
            </div>
            <div class="item">
                <img src="assets/vmall-1212-2.jpg" alt="Third slide" height="100%" width="100%">
            </div>
        </div>
        <!-- 轮播（Carousel）导航 -->
        <a class="carousel-control left" href="#myCarousel" 
        data-slide="prev"> <span _ngcontent-c3="" aria-hidden="true" class="glyphicon glyphicon-chevron-right"  style="opacity: 0.1;"></span></a>
        <a class="carousel-control right" href="#myCarousel" 
        data-slide="next">&rsaquo;</a>

        <div id="main">
            <div id="login_face">
                <br> <br>
                <h2>欢迎光临零售商城</h2>
                <br> <br>
                <form action="login.php" method="POST">
                    <input type="text" class="userinfo" placeholder="用户名" name="account" id="account">
                    <br>
                    <span id="hint"></span>
                    <br>
                    <input type="password" class="userinfo" placeholder="密码" name="password">
                    <br> <br> <br>
                    <input type="submit" class="btn btn-default" value="登录">
                </form>
                <br>
                <span>还没账号？</span> <a href="register_page.php">注册一个</a>
            </div>
        </div>
    </div>
    <script>
        $('#account').blur(function() {
            account=$("#account").val();
            $.post("login_ajax.php",{account:account},function(result){
                $("#hint").html(result);
            });
        })
        
        $('.carousel').carousel({
            interval: 2000
        });
    </script>
    
</body>
</html>