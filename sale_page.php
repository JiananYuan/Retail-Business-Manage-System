<?php
session_start();
error_reporting(0);
header("Content-type:text/html;charset=utf-8");
$acc = $_GET['acc'];
if ($acc == "") {
    echo '<h1>没有权限访问</h1>';
    return ;
}
include('conn.php');
$pid = $_GET['pid'];
echo "<!DOCTYPE html>"
  . "<html lang=\"en\">"
  . "<head>"
  . "   <meta charset=\"UTF-8\">"
  . "   <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">"
  . "   <title>产品销售情况</title>"
  . "   <link rel=\"stylesheet\" href=\"https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css\">  "
  . "   <script src=\"https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js\"></script>"
  . "   <script src=\"https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js\"></script>"
  . "   <style>"
  . "       html, body {"
  . "           height: 100%;"
  . "       }"
  . "       * {"
  . "           padding: 0;"
  . "           margin: 0;"
  . "       }"
  . "       #navigate {"
  . "           background-color: white;"
  . "           border-bottom: 1px solid #eee;"
  . "       }"
  . "       span {"
  . "           vertical-align: middle;"
  . "       }"
  . "       .op {"
  . "           line-height: 78px;"
  . "           margin-left: 70px;"
  . "           vertical-align: middle;"
  . "       }"
  . "       .op a {"
  . "           text-decoration: none;"
  . "           vertical-align: middle;"
  . "       }"
  . "       #table {"
  . "           text-align: center;"
  . "           width: 50%;"
  . "       }"
  . "       #main {"
  . "           margin-top: 50px;"
  . "       }"
  . "   </style>"
  . "</head>"
  . "<body>"
  . "  <div id=\"navigate\">"
  . "       <span>"
  . "            <span><img src=\"assets/logo.jpg\" alt=\"\" width=\"230px\" height=\"78px\"></span>"
  . "            <span class=\"op\"><a href=\"admin_board_1.php?acc=" . $acc . "\">已注册客户</a></span>"
  . "            <span class=\"op\"><a href=\"admin_board_2.php?acc=" . $acc . "\">在职员工</a></span>"
  . "            <span class=\"op\"><a href=\"admin_board_3.php?acc=" . $acc . "\">所有供应商</a></span>"
  . "            <span class=\"op\"><a href=\"admin_board_4.php?acc=" . $acc . "\">购买记录</a></span>"
  . "            <span class=\"op\"><a href=\"admin_board_5.php?acc=" . $acc . "\">月销售情况</a></span>"
  . "            <span class=\"op\"><a href=\"admin_board_6.php?acc=" . $acc . "\">操作记录</a></span>"
  . "            <span class=\"op\"><button type=\"button\" class=\"btn btn-danger\" id=\"btn\">登出</button></span>"
  . "       </span>"
  . "   </div>"
  . "   <div id=\"table\">"
  . "       <table class=\"table table-hover\" style=\"margin-left: 45%; margin-top: 50px;\">"
  . "           <caption>编号为 " . $pid . " 产品的销售情况</caption>"
  . "           <thead>"
  . "               <tr>"
  . "                   <td style=\"font-weight: bold;\">pname</td>"
  . "                   <td style=\"font-weight: bold;\">MONTH</td>"
  . "                   <td style=\"font-weight: bold;\">YEAR</td>"
  . "                   <td style=\"font-weight: bold;\">销量</td>"
  . "                   <td style=\"font-weight: bold;\">销售额</td>"
  . "                   <td style=\"font-weight: bold;\">销售均价</td>"
  . "               </tr>"
  . "           </thead>"
  . "           <tbody>";
  $sql = "call report_monthly_sale('$pid')";
  $res = $conn -> query($sql);
  if ($res -> num_rows > 0) {
  while ($row = $res -> fetch_assoc()) {
    echo "<tr>";
    echo "<td>";
    echo $row['pname'];
    echo "</td>";
    echo "<td>";
    echo $row['SUBSTR(DATE_FORMAT(purchases.ptime, "%M"), 1, 3)'];
    echo "</td>";
    echo "<td>";
    echo $row['DATE_FORMAT(purchases.ptime, "%Y")'];
    echo "</td>";
    echo "<td>";
    echo $row['SUM(qty)'];
    echo "</td>";
    echo "<td>";
    echo $row['SUM(total_price)'];
    echo "</td>";
    echo "<td>";
    echo $row['SUM(total_price)/SUM(qty)'];
    echo "</td>";
    echo "</tr>";
  }
} else if ($conn -> query($sql) -> num_rows <= 0) {
  echo "<tr>";
  echo "<td colspan='6'>";
  echo "没有查找到记录，发生此情况的原因是该商品尚未被购买过或您输入的pid号无效";
  echo "</td>";
  echo "</tr>";
}
echo "               "
  . "           </tbody>"
  . "       </table>"
  . "   </div>"
  . "   <script>"
  . "       $('#btn').click(function() {\n"
  . "           $.ajax({\n"
  . "               url: 'unset_session.php'\n"
  . "           })\n"
  . "           window.location.href='login_page.php';"
  . "       });\n"
  . "   </script>"
  . "</body>"
  . "</html>";
$conn -> close();
?>