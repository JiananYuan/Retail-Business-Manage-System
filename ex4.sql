-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2020 at 09:37 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ex4`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_products`(
	in pid varchar(4),
	in pname varchar(15),
	in qoh int(5),
	in qoh_threshold int(5),
	in original_price decimal(6,2),
	in discnt_rate decimal(3,2),
	in sid varchar(2)
)
BEGIN
	INSERT products (`pid`, `pname`, `qoh`, `qoh_threshold`, `original_price`, `discnt_rate`, `sid`) VALUES (pid, pname, qoh, qoh_threshold, original_price, discnt_rate, sid);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_purchase`(IN `c_id` VARCHAR(4), IN `e_id` VARCHAR(4), IN `p_id` VARCHAR(4), IN `pur_qty` INT(5))
BEGIN
	declare price float(7,2) default(0);
	SELECT original_price*discnt_rate*pur_qty INTO price FROM products WHERE pid = p_id;
	INSERT INTO purchases (`cid`, `eid`, `pid`, `qty`, `ptime`, `total_price`) VALUES (c_id, e_id, p_id, pur_qty, now(), price);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `customer_purchase`(IN `pur_qty` INT(5), IN `c_id` VARCHAR(4), IN `e_id` VARCHAR(4), IN `p_id` VARCHAR(4))
BEGIN
	declare threshold int default(0);
declare msg varchar(100) default(concat('编号为', c_id, '的顾客，您已成功购买编号为', p_id, '的产品，数量为', pur_qty, '。谢谢您的惠顾！'));
	SELECT qoh INTO threshold FROM products WHERE pid = p_id;
	IF pur_qty <= threshold THEN
		UPDATE products SET qoh = qoh-pur_qty WHERE pid = p_id; 
        CALL add_purchase(c_id, e_id, p_id, pur_qty);
        set msg = concat(msg, @msg1);
	ELSE
        set msg = '商品库存不足，请调整购买数量';
	END IF;
    SELECT msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `report_monthly_sale`(in prod_id varchar(4))
BEGIN
    SELECT
        products.pname,  
        SUBSTR(DATE_FORMAT(purchases.ptime, "%M"), 1, 3),  
        DATE_FORMAT(purchases.ptime, "%Y"),  
        SUM(qty), 
        SUM(total_price),  
        SUM(total_price)/SUM(qty)  
    FROM products, purchases  
    WHERE products.pid=prod_id AND products.pid=purchases.pid GROUP BY DATE_FORMAT(purchases.ptime, "%Y"), DATE_FORMAT(purchases.ptime, "%m");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_customers`()
BEGIN
    SELECT * FROM customers;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_employees`()
BEGIN
    SELECT * FROM employees;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_logs`()
BEGIN
    SELECT * FROM logs;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_products`()
BEGIN
    SELECT * FROM products;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_purchases`()
BEGIN
    SELECT * FROM purchases;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `show_suppliers`()
BEGIN
    SELECT * FROM suppliers;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `cid` varchar(4) NOT NULL,
  `cname` varchar(15) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  `visits_made` int(5) DEFAULT '0',
  `last_visit_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cid`, `cname`, `city`, `visits_made`, `last_visit_time`) VALUES
('1', 'customer', 'Shenzhen', 86, '2020-12-19 10:58:12'),
('c1', '顾客1', '上海', 19, '2020-12-22 16:24:29');

--
-- Triggers `customers`
--
DROP TRIGGER IF EXISTS `customers_modify`;
DELIMITER //
CREATE TRIGGER `customers_modify` AFTER UPDATE ON `customers`
 FOR EACH ROW BEGIN
		IF OLD.visits_made != NEW.visits_made THEN
			INSERT INTO logs (`who`, `time`, `table_name`, `operation`, `key_value`)
		    	VALUES (USER(), now(), 'customers', 'update', NEW.cid);
		END IF;
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `eid` varchar(3) NOT NULL,
  `ename` varchar(15) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`eid`, `ename`, `city`) VALUES
('2', 'employee', 'guangzhou'),
('e1', '雇员1', '广州');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `logid` int(5) NOT NULL AUTO_INCREMENT,
  `who` varchar(10) NOT NULL,
  `time` datetime NOT NULL,
  `table_name` varchar(20) NOT NULL,
  `operation` varchar(6) NOT NULL,
  `key_value` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=381 ;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`logid`, `who`, `time`, `table_name`, `operation`, `key_value`) VALUES
(316, 'root@local', '2020-12-19 11:07:55', 'products', 'update', '1000'),
(317, 'root@local', '2020-12-19 11:07:55', 'purchases', 'insert', '106'),
(318, 'root@local', '2020-12-19 11:07:55', 'customers', 'update', 'c1'),
(319, 'root@local', '2020-12-19 11:07:59', 'products', 'update', '1000'),
(320, 'root@local', '2020-12-19 11:07:59', 'purchases', 'insert', '107'),
(321, 'root@local', '2020-12-19 11:07:59', 'products', 'update', '1000'),
(322, 'root@local', '2020-12-19 11:07:59', 'customers', 'update', 'c1'),
(323, 'root@local', '2020-12-22 11:41:41', 'products', 'update', '1001'),
(324, 'root@local', '2020-12-22 11:41:41', 'purchases', 'insert', '108'),
(325, 'root@local', '2020-12-22 11:41:41', 'customers', 'update', 'c1'),
(326, 'root@local', '2020-12-22 11:41:49', 'products', 'update', '1000'),
(327, 'root@local', '2020-12-22 11:41:49', 'purchases', 'insert', '109'),
(328, 'root@local', '2020-12-22 11:41:49', 'customers', 'update', 'c1'),
(329, 'root@local', '2020-12-22 11:42:08', 'products', 'update', '1005'),
(330, 'root@local', '2020-12-22 11:42:08', 'purchases', 'insert', '110'),
(331, 'root@local', '2020-12-22 11:42:08', 'customers', 'update', 'c1'),
(332, 'root@local', '2020-12-22 11:42:17', 'products', 'update', '1005'),
(333, 'root@local', '2020-12-22 11:42:17', 'purchases', 'insert', '111'),
(334, 'root@local', '2020-12-22 11:42:17', 'customers', 'update', 'c1'),
(335, 'root@local', '2020-12-22 11:42:39', 'products', 'update', '1005'),
(336, 'root@local', '2020-12-22 11:42:39', 'purchases', 'insert', '112'),
(337, 'root@local', '2020-12-22 11:42:39', 'customers', 'update', 'c1'),
(338, 'root@local', '2020-12-22 11:45:35', 'products', 'update', '1005'),
(339, 'root@local', '2020-12-22 11:45:35', 'purchases', 'insert', '113'),
(340, 'root@local', '2020-12-22 11:45:35', 'customers', 'update', 'c1'),
(341, 'root@local', '2020-12-22 11:45:42', 'products', 'update', '1005'),
(342, 'root@local', '2020-12-22 11:45:42', 'purchases', 'insert', '114'),
(343, 'root@local', '2020-12-22 11:45:42', 'products', 'update', '1005'),
(344, 'root@local', '2020-12-22 11:45:42', 'customers', 'update', 'c1'),
(345, 'root@local', '2020-12-22 11:47:06', 'products', 'update', '1005'),
(346, 'root@local', '2020-12-22 11:47:55', 'products', 'update', '1005'),
(347, 'root@local', '2020-12-22 11:49:04', 'products', 'update', '1003'),
(348, 'root@local', '2020-12-22 11:49:50', 'products', 'update', '1003'),
(349, 'root@local', '2020-12-22 11:49:50', 'purchases', 'insert', '118'),
(350, 'root@local', '2020-12-22 11:49:50', 'customers', 'update', 'c1'),
(351, 'root@local', '2020-12-22 11:50:00', 'products', 'update', '1000'),
(352, 'root@local', '2020-12-22 11:50:00', 'purchases', 'insert', '119'),
(353, 'root@local', '2020-12-22 11:50:00', 'customers', 'update', 'c1'),
(354, 'root@local', '2020-12-22 11:51:19', 'products', 'update', '1001'),
(355, 'root@local', '2020-12-22 11:51:19', 'purchases', 'insert', '120'),
(356, 'root@local', '2020-12-22 11:51:19', 'customers', 'update', 'c1'),
(357, 'root@local', '2020-12-22 11:55:36', 'products', 'update', '1003'),
(358, 'root@local', '2020-12-22 11:55:36', 'purchases', 'insert', '121'),
(359, 'root@local', '2020-12-22 11:55:36', 'customers', 'update', 'c1'),
(360, 'root@local', '2020-12-22 11:56:47', 'products', 'update', '1000'),
(361, 'root@local', '2020-12-22 11:57:17', 'products', 'update', '1000'),
(362, 'root@local', '2020-12-22 12:04:56', 'products', 'update', '1006'),
(363, 'root@local', '2020-12-22 12:04:57', 'purchases', 'insert', '124'),
(364, 'root@local', '2020-12-22 12:04:57', 'customers', 'update', 'c1'),
(365, 'root@local', '2020-12-22 16:20:16', 'products', 'update', '1000'),
(366, 'root@local', '2020-12-22 16:20:16', 'purchases', 'insert', '125'),
(367, 'root@local', '2020-12-22 16:20:16', 'customers', 'update', 'c1'),
(368, 'root@local', '2020-12-22 16:21:20', 'products', 'update', '1001'),
(369, 'root@local', '2020-12-22 16:21:21', 'purchases', 'insert', '126'),
(370, 'root@local', '2020-12-22 16:21:21', 'customers', 'update', 'c1'),
(371, 'root@local', '2020-12-22 16:21:56', 'products', 'update', '1000'),
(372, 'root@local', '2020-12-22 16:21:56', 'purchases', 'insert', '127'),
(373, 'root@local', '2020-12-22 16:21:56', 'products', 'update', '1000'),
(374, 'root@local', '2020-12-22 16:21:56', 'customers', 'update', 'c1'),
(375, 'root@local', '2020-12-22 16:23:23', 'products', 'update', '1007'),
(376, 'root@local', '2020-12-22 16:23:23', 'purchases', 'insert', '128'),
(377, 'root@local', '2020-12-22 16:23:23', 'customers', 'update', 'c1'),
(378, 'root@local', '2020-12-22 16:24:29', 'products', 'update', '1001'),
(379, 'root@local', '2020-12-22 16:24:29', 'purchases', 'insert', '129'),
(380, 'root@local', '2020-12-22 16:24:29', 'customers', 'update', 'c1');

-- --------------------------------------------------------

--
-- Table structure for table `picurl`
--

CREATE TABLE IF NOT EXISTS `picurl` (
  `src` varchar(100) NOT NULL,
  `pid` varchar(4) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picurl`
--

INSERT INTO `picurl` (`src`, `pid`) VALUES
('assets/xing.jpg', '1000'),
('assets/u=4054347203,639861629&fm=26&gp.jpg', '1001'),
('assets/huawei.jpg', '1003'),
('assets/3feaa823e0510889.jpg', '1004'),
('assets/f92fe87e020ed5d1.jpg', '1005'),
('assets/db.png', '1006'),
('assets/air.jpg', '1007');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pid` varchar(4) NOT NULL,
  `pname` varchar(15) NOT NULL,
  `qoh` int(5) NOT NULL,
  `qoh_threshold` int(5) DEFAULT NULL,
  `original_price` decimal(6,2) DEFAULT NULL,
  `discnt_rate` decimal(3,2) DEFAULT NULL,
  `sid` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `pname`, `qoh`, `qoh_threshold`, `original_price`, `discnt_rate`, `sid`) VALUES
('1000', '星巴克咖啡', 14, 7, '50.00', '1.00', '0'),
('1001', 'Javaer', 339, 100, '104.50', '0.90', '0'),
('1003', 'Mate 40', 994, 200, '6999.00', '0.98', '0'),
('1004', 'ZTE 5G', 600, 200, '899.00', '0.98', '0'),
('1005', '打印复印扫描', 6394, 22, '2759.00', '0.98', 's1'),
('1006', '数据库', 998, 100, '36.00', '0.95', 's1'),
('1007', 'airpods', 1996, 100, '1000.00', '0.98', 's1');

--
-- Triggers `products`
--
DROP TRIGGER IF EXISTS `products_modify`;
DELIMITER //
CREATE TRIGGER `products_modify` AFTER UPDATE ON `products`
 FOR EACH ROW BEGIN
		IF OLD.qoh != NEW.qoh THEN
INSERT INTO logs (`who`, `time`, `table_name`, `operation`, `key_value`)
VALUES (USER(), now(), 'products', 'update', NEW.pid);
        END IF;
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `pur` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(4) NOT NULL,
  `eid` varchar(3) NOT NULL,
  `pid` varchar(4) NOT NULL,
  `qty` int(5) DEFAULT NULL,
  `ptime` datetime DEFAULT NULL,
  `total_price` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`pur`),
  KEY `cid` (`cid`),
  KEY `eid` (`eid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`pur`, `cid`, `eid`, `pid`, `qty`, `ptime`, `total_price`) VALUES
(1, 'c1', '2', '1000', 7, '2020-12-19 10:51:20', '350.00'),
(2, 'c1', '2', '1000', 1, '2020-12-19 10:52:18', '50.00'),
(104, 'c1', '2', '1000', 7, '2020-12-19 11:05:35', '350.00'),
(105, 'c1', '2', '1000', 1, '2020-12-19 11:05:38', '50.00'),
(106, 'c1', '2', '1000', 7, '2020-12-19 11:07:55', '350.00'),
(107, 'c1', '2', '1000', 1, '2020-12-19 11:07:59', '50.00'),
(108, 'c1', '2', '1001', 1, '2020-12-22 11:41:41', '94.05'),
(109, 'c1', '2', '1000', 1, '2020-12-22 11:41:49', '50.00'),
(119, 'c1', 'e1', '1000', 3, '2020-12-22 11:50:00', '150.00'),
(120, 'c1', 'e1', '1001', 1, '2020-12-22 11:51:19', '94.05'),
(121, 'c1', 'e1', '1003', 2, '2020-12-22 11:55:36', '13718.04'),
(124, 'c1', 'e1', '1006', 2, '2020-12-22 12:04:57', '68.40'),
(125, 'c1', 'e1', '1000', 1, '2020-12-22 16:20:16', '50.00'),
(126, 'c1', 'e1', '1001', 1, '2020-12-22 16:21:21', '94.05'),
(127, 'c1', 'e1', '1000', 3, '2020-12-22 16:21:56', '150.00'),
(128, 'c1', 'e1', '1007', 4, '2020-12-22 16:23:23', '3920.00'),
(129, 'c1', 'e1', '1001', -1, '2020-12-22 16:24:29', '-94.05');

--
-- Triggers `purchases`
--
DROP TRIGGER IF EXISTS `purchases_insert`;
DELIMITER //
CREATE TRIGGER `purchases_insert` AFTER INSERT ON `purchases`
 FOR EACH ROW BEGIN
		declare remain_num int default(0);
		declare threshold int default(0);

		INSERT INTO logs (`who`, `time`, `table_name`, `operation`, `key_value`) VALUES (USER(), now(), 'purchases', 'insert', NEW.pur);      
		SELECT qoh INTO remain_num FROM products WHERE pid = NEW.pid;
		set @msg1 = '';
		set @msg1 = concat('顾客购买后库存量：', remain_num);
		SELECT qoh_threshold INTO threshold FROM products WHERE pid = NEW.pid;
		IF remain_num<threshold THEN
			UPDATE products SET qoh=2*(NEW.qty+qoh) WHERE pid = NEW.pid;
			set @msg1 = concat(@msg1, '。已成功补货，补充数量为：', (2*NEW.qty+remain_num));
		END IF;
		UPDATE customers SET visits_made = visits_made+1 WHERE cid = NEW.cid;
		UPDATE customers SET last_visit_time = now() WHERE cid = NEW.cid;
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `sid` varchar(2) NOT NULL,
  `sname` varchar(15) NOT NULL,
  `city` varchar(15) DEFAULT NULL,
  `telephone_no` char(10) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `sname` (`sname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`sid`, `sname`, `city`, `telephone_no`) VALUES
('0', 'supplier', 'shenzhen', '123456789'),
('s1', '供应商1', '北京', '123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `suppliers` (`sid`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customers` (`cid`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`eid`) REFERENCES `employees` (`eid`),
  ADD CONSTRAINT `purchases_ibfk_3` FOREIGN KEY (`pid`) REFERENCES `products` (`pid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
