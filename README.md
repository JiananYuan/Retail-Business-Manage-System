#  RBMS项目文档

## 一. 项目功能

本项目基于MySQL的存储过程、触发器和PHP后端设计，以前端组件作为呈现界面，较为完整地模拟了一个网上应用商城的运作过程，提供了一个网上应用商城(RBMS)的基本实现，设定了不同用户角色，如顾客、店员、供应商等，并对不同的身份设定了不同的操作和权限。

## 二. 项目特色

- 使用了H5/Js/Css等基础前端技术
- 使用了jQuery高效前端开发技术
- 使用了Ajax前端用户交互技术
- 使用了BootStrap框架进行组件化开发
- 使用Session保持用户会话
- 以关系型数据库MySQL作为后台数据库存储
- 使用phpMyAdmin作为数据库系统管理工具
- 使用存储过程和触发器实现数据库自动化

## 三. 项目使用

1. 登录localhost/ex4访问项目主页：

   ![](https://www.png8.com/imgs/2020/12/5e2ae0808104d6c0.jpg)

2. 点击“登入”，进入到用户登录界面：

   ![](https://www.png8.com/imgs/2020/12/a78adac5bd40c856.jpg)

3. 已注册账号可直接登录，没注册账号点击“注册一个”进入注册界面：

   ![](https://www.png8.com/imgs/2020/12/7e4c22c0cf53ec68.jpg)

4. 用户登录后，可购买商品：

   ![](https://www.png8.com/imgs/2020/12/34651e9a93ab7c7b.jpg)

5. 雇员登录后，可查看数据库列表：

   ![](https://www.png8.com/imgs/2020/12/967b1c9fd5f5fe3d.jpg)

6. 供应商登录后，可向商城提供商品：

   ![](https://www.png8.com/imgs/2020/12/d9e11d69650feb17.jpg)

7. 其他功能请参阅《Using mysql and php to implement the retail business management system.doc》


## 四. 项目文件说明

|文件名|实现功能|
|----|----|
|assets|资源资源文件夹 (图片类)|
|jquery-3.5.1.min.js|jQuery库文件|
|css/js文件夹|bootstrap 框架依赖文件|
|conn.php|(后端) 封装，负责登录后台数据库|
|login_page.php|(前端) 用户登录首页|
|login_ajax.php|(后端) 使用Ajax技术检查用户名是否存在并及时给用户反馈|
|login.php|(后端) 核对用户名和密码，登入零售商城|
|register_page.php|(前端) 用户注册页面|
|register.php|(后端)用户注册逻辑|
|index.php|(前端)展示商品界面：products表|
|customer_buy.php|(后端)处理用户的购买逻辑|
|admin_board_1.php|(前端)显示已注册的客户信息：customers表|
|admin_board_2.php|(前端)显示在职员工信息：employees表|
|admin_board_3.php|(前端)显示供应商:suppliers表|
|admin_board_4.php|(前端)显示购买记录：purchases表|
|admin_board_5.php|(前端)输入pid跳转月销售情况页面|
|admin_board_6.php|(前端)显示操作记录：logs表|
|sale_page.php|(前端)显示产品销售情况：调用report_monthly_sale存储过程|
|unset_session.php|(后端)用户登出时删除Session|
|add_product.php|(后端)处理产品引入逻辑|
|add_product_page.php|(前端)引入新产品界面|

## 五.  数据库中定义的存储过程和触发器

| 存储过程            | 作用               |
| ------------------- | ------------------ |
| show_customers      | 显示customers表    |
| show_employees      | 显示employees表    |
| show_suppliers      | 显示suppliers表    |
| show_logs           | 显示logs表         |
| show products       | 显示products表     |
| show purchases      | 显示purchases表    |
| report_monthly_sale | 显示商品销售情况表 |
| customer_purchase   | 处理用户购买逻辑   |
| add_products        | 添加商品           |
| add_purchase        | 添加购买记录       |

| 触发器           | 作用                                       |
| ---------------- | ------------------------------------------ |
| customers_modify | 在logs表中添加顾客访问数+1 (update) 的记录 |
| products_modify  | 在logs表中添加商品数量减少 (update) 的记录 |
| purchases_insert | 在logs表中添加顾客购买商品 (insert) 的记录 |

## 六. 一键部署

在项目的根目录下，有一个ex4.sql文件，可以实现数据库的机器间移植。当要将数据库从一个机器上移植到另外一个机器上时，只需要在新的机器MySQL服务器上新建名为ex4的数据库，并将ex4.sql文件导入到新的数据库里面，即可实现快速部署。



