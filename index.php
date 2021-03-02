<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>零售商城</title>
    <style>
        html, body {
            height: 135%;
            background-image: linear-gradient(to right,#fbc2eb,#a6c1ee);
        }
        * {
            padding: 0;
            margin: 0;
        }
        #navigate {
            background-color: white;
        }
        #board {
            
        }
        .item {
            border-radius: 15px;
            border: gray 1px solid;
            width: 250px;
            height: 460px;
            float: left;
            margin-left: 100px;
            margin-top: 70px;
        }
        .item img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        #info {
            padding-left: 10px;
            border-top: 1px gray solid;
            border-bottom: 1px gray solid;
            background-color: white;
        }
        p {
            font-size: 17px;
        }
        span img {
            cursor: pointer;
        }
        li {
            float: left;
            list-style: none;
        }
    </style>
    <script src="jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<?php
    include('conn.php');
    error_reporting(0);
    session_start();
    $acc = $_GET['acc'];
    if($acc != "" && isset($_SESSION['$acc']) && $_SESSION['$acc'] == true) {
        echo("<div id=\"navigate\">");
        echo("        <span>");
        echo("            <img src=\"assets/logo.jpg\" alt=\"\" width=\"230\" height=\"78\">");
        echo("        </span>");
        echo("        <span style=\"margin-left:70%\">");
        echo("            <button type=\"button\" class=\"btn btn-danger\" id=\"login_btn\">登出</button>");
        echo("        </span>");
        echo("    </div>");
        echo("    <ul id=\"board\">");
    }
    else {
        echo("<div id=\"navigate\">");
        echo("        <span>");
        echo("            <img src=\"assets/logo.jpg\" alt=\"\" width=\"230\" height=\"78\">");
        echo("        </span>");
        echo("        <span style=\"margin-left:70%\">");
        echo("            <button type=\"button\" class=\"btn btn-success\" id=\"login_btn\">登入</button>");
        echo("        </span>");
        echo("    </div>");
        echo("    <ul id=\"board\">");
    }
    $res = $conn -> query('call show_products()');
    $conn -> close();
    // 这里卡了挺久的，应该总结一下
    include ('conn.php');
    if ($res -> num_rows > 0) {
        while ($row = $res -> fetch_assoc()) {
            echo "       <li class=\"item\">\n";
            $sql = 'SELECT * FROM picurl WHERE pid = "' . $row['pid'] . '"';
            $pic = $conn->query($sql);
            if ($pic -> num_rows > 0) {
                echo "           <img src=\"" . $pic->fetch_assoc()["src"] . "\" height='248px' width='248px'>\n";
            }
            else {
                echo "           <img src=\"./assets/item.jpg\" alt=\"\" width=\"248\" height=\"248\">\n";
            }
            echo "           <div id=\"info\">\n";
            echo "               <div>产品编号pid：" . $row['pid'] . "</div>\n";
            echo "               <div>产品名pname：" . $row['pname'] . "</div>\n";
            echo "               <div>产品库存qoh：" . $row['qoh'] . "</div>\n";
            echo "               <div>产品阈值qoh_threshold：" . $row['qoh_threshold'] . "</div>\n";
            echo "               <div>产品原价original_price：" . $row['original_price'] . "</div>\n";
            echo "               <div>产品折扣discnt_rate：" . $row['discnt_rate'] . "</div>\n";
            echo "               <div>供应商号sid：" . $row['sid'] . "</div>\n";
            echo "           </div>\n";
            echo "           <div style=\"padding-top: 5px; text-align: center;height: 40px; border-bottom-right-radius: 15px; border-bottom-left-radius: 15px; background-color: white;\">\n";
            echo "               <form action='customer_buy.php' method='POST' id=" . $row['pid'] . ">\n";
            // echo "                   <input type='hidden' name='pid' value=" . $row['cid'] . ">";
            echo "                   <input type='hidden' name='cid' value=" . $acc . ">";
            echo "                   <input type='hidden' name='pid' value=" . $row['pid'] . ">";
            echo "                   <input type='hidden' name='eid' value=" . $row['sid'] . ">";
            echo "                   <span><img src=\"./assets/sub.png\" alt=\"\" height=\"=27px\" width=\"27px\" id=sub" . $row['pid'] . "></span>\n";
            echo "                   <span><input type=\"text\" disabled='disabled' style=\"outline: none;width: 50px;text-align: center;\" value=\"0\" name='qty' id=num" . $row['pid'] . "></span>\n";
            echo "                   <span><img src=\"./assets/add.png\" alt=\"\" height=\"30px\" width=\"30px\" id=add" . $row['pid'] . "></span>\n";
            echo "                   <span style=\"padding-left: 15px;\"><input type=\"submit\" value=\"购买\"></span>\n";
            echo "               </form>\n";
            echo "           </div>\n";
            echo "       </li>\n";
            echo "   <script>\n";
            echo "       var sub = document.getElementById('sub" . $row['pid'] . "');\n";
            echo "       var add = document.getElementById('add" . $row['pid'] . "');\n";
            echo "       add.onclick = function() {\n";
            echo "           var num = document.getElementById('num" . $row['pid'] . "');\n";
            echo "           num.setAttribute('value', parseInt(num.value)+1);\n";
            echo "       };\n";
            echo "       sub.onclick = function() {\n";
            echo "           var num = document.getElementById('num" . $row['pid'] . "');\n";
            echo "           num.setAttribute('value', Math.max(0, parseInt(num" . $row['pid'] . ".value)-1))\n";
            echo "       };\n";
            echo "   </script>\n";
        }
    }
    $conn -> close();
    echo "</ul>\n";
    echo "   <script>\n";
    if ($acc != "" && isset($_SESSION['$acc']) && $_SESSION['$acc'] == true) {
        echo "$('#login_btn').click(function() {\n";
        echo "           $.ajax({\n";
        echo "               url: 'unset_session.php'\n";
        echo "           })\n";
        echo "           window.location.replace('index.php')";
        echo "       });\n";
    } else {
        echo "$('#login_btn').click(function() {\n";
        echo "    window.location.href='login_page.php';";
        echo "})";
    }
    echo "   </script>\n";
?>
</body>
</html>







