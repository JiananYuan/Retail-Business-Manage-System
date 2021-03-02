<?php
    session_start();
    error_reporting(0);
    header("Content-type:text/html;charset=utf-8");
    $acc = $_GET['acc'];
    if ($acc == "" || !isset($_SESSION['$acc']) || !$_SESSION['$acc']) {
        echo '<h1>没有权限访问</h1>';
        return ;
    }
?>

<?php
    echo("<!DOCTYPE html>");
    echo("<html lang=\"en\">");
    echo("<head>");
    echo("    <meta charset=\"UTF-8\">");
    echo("    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">");
    echo("    <title>RBMS后台列表</title>");
    echo("    <style>");
    echo("        html, body {");
    echo("            height: 100%;");
    echo("            /* background-image: linear-gradient(to right,#fbc2eb,#a6c1ee); */");
    echo("        }");
    echo("        * {");
    echo("            padding: 0;");
    echo("            margin: 0;");
    echo("        }");
    echo("        #navigate {");
    echo("            background-color: white;");
    echo("            border-bottom: 1px solid #eee;");
    echo("        }");
    echo("        span {");
    echo("            vertical-align: middle;");
    echo("        }");
    echo("        .op {");
    echo("            line-height: 78px;");
    echo("            margin-left: 70px;");
    echo("            vertical-align: middle;");
    echo("        }");
    echo("        .op a {");
    echo("            text-decoration: none;");
    echo("            vertical-align: middle;");
    echo("        }");
    echo("        #table {");
    echo("            text-align: center;");
    echo("            width: 50%;");
    echo("        }");
    echo("    </style>");
    echo("    <link rel=\"stylesheet\" href=\"https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css\">  ");
    echo("	<script src=\"https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js\"></script>");
    echo("	<script src=\"https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js\"></script>");
    echo("</head>");
    echo("<body>");
    echo("    <div id=\"navigate\">");
    echo("        <span>");
    echo("            <span><img src=\"assets/logo.jpg\" alt=\"\" width=\"230px\" height=\"78px\"></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_1.php?acc=" . $acc . "\">已注册客户</a></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_2.php?acc=" . $acc . "\">在职员工</a></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_3.php?acc=" . $acc . "\">所有供应商</a></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_4.php?acc=" . $acc . "\">购买记录</a></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_5.php?acc=" . $acc . "\">月销售情况</a></span>");
    echo("            <span class=\"op\"><a href=\"admin_board_6.php?acc=" . $acc . "\">操作记录</a></span>");
    echo("            <span class=\"op\"><button type=\"button\" class=\"btn btn-danger\" id=\"btn\">登出</button></span>");
    echo("        </span>");
    echo("    </div>");
    echo("    <div id=\"table\">");
    echo("        <table class=\"table table-hover\" style=\"margin-left: 45%; margin-top: 50px;\">");
    echo("            <caption>employees表</caption>");
    echo("            <thead>");
    echo("                <tr>");
    echo("                    <td style=\"font-weight: bold;\">eid</td>");
    echo("                    <td style=\"font-weight: bold;\">ename</td>");
    echo("                    <td style=\"font-weight: bold;\">city</td>");
    echo("                </tr>");
    echo("            </thead>");
    echo("            <tbody>");
?>

<?php
include('conn.php');
$sql = 'call show_employees()';
$res = $conn->query($sql);
if ($res -> num_rows > 0) {
    while ($row = $res -> fetch_assoc()) {
        echo '<tr>';
        echo '<td>';
        echo $row['eid'];
        echo '</td>';
        echo '<td>';
        echo $row['ename'];
        echo '</td>';
        echo '<td>';
        echo $row['city'];
        echo '</td>';
        echo '</tr>';
    }
}
$conn->close();
echo '</tbody>';
echo '</table>';
echo '</div>';
echo "   <script>\n";
echo "$('#btn').click(function() {\n";
echo "           $.ajax({\n";
echo "               url: 'unset_session.php'\n";
echo "           })\n";
echo "           window.location.href='login_page.php';";
echo "       });\n";
echo "   </script>\n";
?>
</body>
</html>