<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册零售商城</title>
    <style>
        html, body {
            height: 100%;
        }
        * {
            padding: 0;
            margin: 0;
        }
        #main {
            text-align: center;
            background-image: linear-gradient(to right,#fbc2eb,#a6c1ee);
            height: 100%;
            width: 100%;
        }
        #login_face {
            height: 650px;
            width: 600px;
            background-color: snow;
            border-radius: 20px;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: left;
            padding-left: 20px;
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
    <div id="main">
        <div id="login_face">
            <br> <br>
            <div style="text-align: center;">
                <h2>欢迎您注册</h2>
            </div>
            <br>
            <form class="form-horizontal" role="form" method="POST" action="register.php">
                <div class="form-group" style="padding: 0 15px; padding-right: 115px;">
                    <label for="name">您要注册的是</label>
                    <select class="form-control" id="op" name="op">
                      <option value="customer">customer</option>
                      <option value="employee">employee</option>
                      <option value="supplier">supplier</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="firstname"  style="padding: 0 15px; padding-right: 115px;">id号</label><br><br>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="id" placeholder="请输入id号" name="id">
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname"  style="padding: 0 15px; padding-right: 115px;">姓名</label><br><br>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="请输入姓名" name="name">
                  </div>
                </div>
                <div class="form-group">
                    <label for="lastname"  style="padding: 0 15px; padding-right: 115px;">城市</label><br><br>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="city" placeholder="请输入城市" name="city">
                    </div>
                </div>
                <div class="form-group" style="display: none;" id="phone">
                    <label for="lastname"  style="padding: 0 15px; padding-right: 115px;">联系电话</label><br><br>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" placeholder="请输入联系方式" name="phone">
                    </div>
                </div>
                <br>
                <div class="form-group" style="padding-left: 200px;">
                  <div>
                    <button type="submit" class="btn btn-default">注册</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('#account').blur(function() {
            account=$("#account").val();
            $.post("login_ajax.php",{account:account},function(result){
                $("#hint").html(result);
            });
        })

        $(document).ready(function() {
            $('#op').change(function() {
                var op = $(this).children('option:selected').val()
                if (op == 'supplier') {
                    phone.style.display = 'block';
                } else {
                    phone.style.display = 'none';
                }
            })
        })
    </script>
</body>
</html>