<?php
session_start();
error_reporting(0);
header("Content-type:text/html;charset=utf-8");
$acc = $_GET['acc'];
if ($acc == "" || !isset($_SESSION['$acc']) || !$_SESSION['$acc']) {
  echo '<h1>没有权限访问</h1>';
  return ;
}
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
  . "           text-align: center;"
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
  . "   <div id=\"main\">"
  . "       <img src=\"assets/logo.jpg\">"
  . "       <form action='sale_page.php' class=\"form-horizontal\" role=\"form\">"
  . "           <div class=\"form-group\" style='margin-left: 35%; margin-top: 2%;'>"
  . "               <div class=\"col-sm-5\">"
  . "                 <input class=\"form-control\" id=\"focusedInput\" type=\"text\" placeholder=\"输入产品 pid 号\" name='pid'>"
  . "               </div>"
  . "            </div>"
  . "            <input type=\"hidden\" value=\"" . $acc . "\" name='acc'>"
  . "            <input type=\"submit\" class=\"btn btn-default\" value='搜索'>"
  . "       </form>"
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
?>