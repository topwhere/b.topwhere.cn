# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.21-MariaDB)
# Database: ysdbank
# Generation Time: 2017-12-21 03:22:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table areas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `areas`;

CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;

INSERT INTO `areas` (`id`, `city_id`, `value`, `created_at`, `updated_at`)
VALUES
	(2,2,'塘沽','2017-12-11 20:27:00','2017-12-11 20:37:06'),
	(3,1,'朝阳区','2017-12-11 20:35:09','2017-12-11 20:44:02'),
	(4,1,'丰台区','2017-12-11 20:35:18','2017-12-11 20:43:47'),
	(5,3,'惠山','2017-12-11 20:36:49','2017-12-11 20:36:49'),
	(6,3,'崇安','2017-12-11 20:36:55','2017-12-11 20:36:55'),
	(9,5,'12121212','2017-12-14 10:40:08','2017-12-14 10:40:45'),
	(10,7,'朝阳区','2017-12-15 15:51:48','2017-12-15 15:51:48'),
	(11,7,'海淀区','2017-12-15 15:51:57','2017-12-15 15:51:57'),
	(12,7,'东城区','2017-12-15 15:52:06','2017-12-15 15:52:06'),
	(13,7,'西城区','2017-12-15 15:52:13','2017-12-15 15:52:13'),
	(14,7,'丰台区','2017-12-15 15:52:20','2017-12-15 15:52:20'),
	(15,7,'大兴区','2017-12-15 15:52:27','2017-12-15 15:52:27'),
	(16,7,'昌平区','2017-12-15 15:52:34','2017-12-15 15:52:34'),
	(17,7,'顺义区','2017-12-15 15:52:42','2017-12-15 15:52:42'),
	(18,1,'南京','2017-12-18 11:49:16','2017-12-18 11:49:16'),
	(19,1,'苏州','2017-12-18 11:50:11','2017-12-18 11:50:11'),
	(22,13,'江宁区','2017-12-18 23:58:54','2017-12-18 23:58:54'),
	(23,13,'玄武区','2017-12-18 23:59:12','2017-12-18 23:59:12'),
	(24,11,'东城区','2017-12-19 11:17:42','2017-12-19 11:17:42'),
	(25,11,'西城区','2017-12-19 11:17:49','2017-12-19 11:17:49'),
	(26,11,'朝阳区','2017-12-19 11:18:18','2017-12-19 11:18:18'),
	(27,11,'海淀区','2017-12-19 11:18:24','2017-12-19 11:18:24'),
	(28,11,'大兴区','2017-12-19 11:18:34','2017-12-19 11:18:34'),
	(29,11,'丰台区','2017-12-19 11:18:49','2017-12-19 11:18:49'),
	(30,11,'昌平区','2017-12-19 11:18:56','2017-12-19 11:18:56'),
	(31,11,'顺义区','2017-12-19 11:19:12','2017-12-19 11:19:12');

/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table brands
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table busines
# ------------------------------------------------------------

DROP TABLE IF EXISTS `busines`;

CREATE TABLE `busines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `busines` WRITE;
/*!40000 ALTER TABLE `busines` DISABLE KEYS */;

INSERT INTO `busines` (`id`, `city_id`, `value`, `created_at`, `updated_at`)
VALUES
	(1,1,'簋街','2017-12-11 20:56:40','2017-12-11 20:56:40'),
	(2,1,'吃的地方','2017-12-11 20:56:57','2017-12-11 20:56:57'),
	(3,2,'天津港','2017-12-11 20:57:20','2017-12-11 20:57:20'),
	(4,2,'港口','2017-12-11 20:57:28','2017-12-11 20:57:34'),
	(6,3,'欧风街','2017-12-11 20:57:51','2017-12-11 20:57:51'),
	(7,3,'步行街','2017-12-11 20:57:56','2017-12-11 20:57:56'),
	(8,3,'吃吃吃','2017-12-11 20:58:01','2017-12-11 20:58:01'),
	(9,5,'1212','2017-12-14 10:40:35','2017-12-14 10:40:35'),
	(10,6,'文昌商圈','2017-12-15 15:51:21','2017-12-15 15:51:21'),
	(11,6,'京华城商圈','2017-12-15 15:51:32','2017-12-15 15:51:32'),
	(12,11,'永旺商圈','2017-12-18 18:37:32','2017-12-18 18:37:32'),
	(13,11,'立水桥','2017-12-18 18:37:39','2017-12-18 18:37:39'),
	(14,11,'霍营','2017-12-18 18:37:46','2017-12-18 18:37:46'),
	(15,11,'亚运村/奥体中心','2017-12-19 11:44:47','2017-12-19 11:44:47'),
	(16,11,'前门/崇文门','2017-12-19 11:50:11','2017-12-19 11:50:11'),
	(17,11,'首都机场/新国展','2017-12-19 12:28:40','2017-12-19 12:28:40'),
	(18,11,'燕莎/三里屯','2017-12-19 12:37:16','2017-12-19 12:37:16'),
	(19,11,'永定门/南站/大红门/南苑','2017-12-19 14:03:37','2017-12-19 14:03:37'),
	(20,11,'天安门/王府井','2017-12-19 14:07:49','2017-12-19 14:07:49'),
	(21,11,'公主坟/五棵松/石景山游乐园','2017-12-19 14:14:23','2017-12-19 14:19:30'),
	(22,11,'小汤山温泉区','2017-12-19 14:22:13','2017-12-19 14:22:13'),
	(23,11,'国展中心','2017-12-19 14:26:17','2017-12-19 14:26:17'),
	(24,11,'国贸CBD','2017-12-19 15:24:59','2017-12-19 15:24:59'),
	(25,11,'亦庄','2017-12-19 15:28:54','2017-12-19 15:28:54');

/*!40000 ALTER TABLE `busines` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`id`, `province_id`, `value`, `created_at`, `updated_at`)
VALUES
	(11,11,'北京','2017-12-18 17:16:46','2017-12-19 11:17:17'),
	(13,10,'南京','2017-12-18 23:58:35','2017-12-18 23:58:35'),
	(14,10,'苏州','2017-12-19 11:10:55','2017-12-19 11:10:55'),
	(15,10,'无锡','2017-12-19 11:11:02','2017-12-19 11:11:02');

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'logo',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司id',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司区域',
  `department` text COLLATE utf8_unicode_ci NOT NULL COMMENT '公司部门',
  `duty` text COLLATE utf8_unicode_ci NOT NULL COMMENT '公司职务',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;

INSERT INTO `companies` (`id`, `logo`, `name`, `company_id`, `address`, `department`, `duty`, `created_at`, `updated_at`)
VALUES
	(4,'avatars/CjQHGeZoBFz8iOhvKgx4R0q8J8MAzSTAYTcDoGb5.jpeg','好棋控股','HQH0101001','好棋控股总部','董事会,总裁室,综合管理中心,综合管理中心-人力资源部,综合管理中心-行政管理部,财务管理中心,财务管理中心-财务部,财务管理中心-审计部,投资管理中心,投资管理中心-资产管理部,投资管理中心-企业管理部,发展规划中心,营销策划中心','董事长,总裁,副总裁,部门总经理,总监,经理,主管,专员','2017-12-19 11:08:59','2017-12-19 11:10:11');

/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table configs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;

INSERT INTO `configs` (`id`, `type`, `name`, `value`, `created_at`, `updated_at`)
VALUES
	(6,'grade','普通会员','0',NULL,NULL),
	(7,'grade','白银会员','1000',NULL,NULL),
	(9,'grade','超级会员','1000000','2017-12-18 00:08:02','2017-12-18 00:08:02'),
	(10,'province','','江苏','2017-12-18 16:58:55','2017-12-18 23:58:18'),
	(11,'province','','北京','2017-12-18 16:59:29','2017-12-18 16:59:29'),
	(12,'service','','Wi-Fi','2017-12-19 10:55:48','2017-12-19 10:55:48'),
	(13,'service','','免费停车场','2017-12-19 10:56:08','2017-12-19 10:56:41'),
	(14,'service','','收费停车场','2017-12-19 10:56:51','2017-12-19 10:56:51'),
	(15,'service','','健身房','2017-12-19 10:57:29','2017-12-19 10:58:22'),
	(16,'service','','游泳池','2017-12-19 10:58:30','2017-12-19 10:58:30'),
	(17,'service','','行李寄存','2017-12-19 10:58:41','2017-12-19 10:58:41');

/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table coupon_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `coupon_users`;

CREATE TABLE `coupon_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coupon_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table coupons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '面值',
  `reggive` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册赠送',
  `limit` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '使用限制',
  `start` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '有效期开始',
  `end` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '有效期结束',
  `describe` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table hotels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hotels`;

CREATE TABLE `hotels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '图片',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '酒店名',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '营业状态',
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '电话',
  `price` double(10,2) NOT NULL COMMENT '价格',
  `service` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '设施服务',
  `star` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '星级',
  `pay` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '支付方式',
  `province` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '所属城市',
  `business` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '商圈',
  `subway` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '地铁',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '地址',
  `lon` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '经度',
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '纬度',
  `profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '简介',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;

INSERT INTO `hotels` (`id`, `img`, `name`, `status`, `tel`, `price`, `service`, `star`, `pay`, `province`, `city`, `business`, `subway`, `address`, `lon`, `lat`, `profile`, `created_at`, `updated_at`)
VALUES
	(5,'avatars/FZKS19e7y4CoqKthrUgwUUYrTzl1wCiUHlK6NO7P.jpeg','北辰洲际酒店','1','010-52895700',950.00,'12,14,15,16,17','5','微信','11','11','15','16,21','北辰西路8号院4号楼','116.394421','40.004526','酒店地处北京朝阳区北辰西路，步行即可到达大型综合商场天虹百货，吃喝玩乐一应俱全！娱乐室提供休闲KTV影音设备，75寸家庭影院视觉享乐，是放松娱乐的上佳选择。','2017-12-19 11:43:53','2017-12-19 11:47:49'),
	(8,NULL,'富力智选假日酒店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','南纬路36号','116.397398','39.886697','2008年开业 2015年装修','2017-12-19 12:21:17','2017-12-19 12:21:17'),
	(9,NULL,'民族园智选假日酒店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','民族园路2号3幢（地铁10号线北土城F口）','116.397503','39.985633','2008年开业 2015年装修','2017-12-19 12:26:59','2017-12-19 12:26:59'),
	(10,NULL,'临空智选假日酒店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','京顺东街6号院1号楼','116.535637','40.030563','2012年开业 2012年装修','2017-12-19 12:32:43','2017-12-19 12:32:43'),
	(11,NULL,'亮马河饭店','1','010-52895700',600.00,'on','4','微信','11','11','on','on','东三环北路8号','116.469379','39.951668','酒店地处北京东三环北路，步行即可到达大型综合商场燕莎友谊商城，吃喝玩乐一应俱全。','2017-12-19 12:36:57','2017-12-19 12:38:20'),
	(12,NULL,'中成天坛假日酒店','1','010-52895700',600.00,'on','4','微信','11','11','on','on','南三环安定东里1号','116.420822','39.867864','步行至天坛公园10分钟，近天坛医院、友谊医院。','2017-12-19 14:03:02','2017-12-19 14:05:50'),
	(13,NULL,'新侨诺富特饭店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','崇文门西大街1号','116.423205','39.908044','酒店建成至今已有60年的历史，悠悠岁月，沧海桑田，见证北京的盛衰沉浮。','2017-12-19 14:12:20','2017-12-19 14:12:20'),
	(14,NULL,'长峰假日酒店','1','010-52895700',550.00,'on','4','微信','11','11','on','on','永定路66号','116.271548','39.915719','近武警总医院，301医院，五棵松地铁站，五棵松体育馆。','2017-12-19 14:19:00','2017-12-19 14:20:36'),
	(15,NULL,'龙城华美达酒店','1','010-52895700',550.00,'on','4','微信','11','11','on','on','昌平路319号','116.310652','40.090361','近京藏高速，酒吧、健身中心、SPA、游泳馆等康体娱乐设施俱全。','2017-12-19 14:24:56','2017-12-19 14:24:56'),
	(16,NULL,'诺富特三元酒店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','曙光西里甲5号18座','116.462002','39.966996','近地铁10号线/机场线三元桥站D口','2017-12-19 14:29:16','2017-12-19 14:29:16'),
	(17,NULL,'贝尔特酒店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','崇文门外大街3-18号','116.423706','39.904542','近崇文门新世界商场后面，吃喝玩乐一应俱全。','2017-12-19 14:37:17','2017-12-19 14:37:17'),
	(18,NULL,'京伦饭店','1','010-52895700',600.00,'on','4','微信','11','11','on','on','建国门外大街3号','116.461419','39.914703','酒店地处北京建国门外大街，邻近国贸商场和银泰中心两处大型综合商场。','2017-12-19 15:28:15','2017-12-19 15:28:15'),
	(19,NULL,'兴基铂尔曼饭店','1','010-52895700',600.00,'on','2','微信','11','11','on','on','经济技术开发区荣华南路12号','116.522508','39.792809','近京东总部','2017-12-19 15:31:31','2017-12-19 15:31:31'),
	(20,NULL,'中奥马哥孛罗大酒店','1','010-52895700',650.00,'on','5','微信','11','11','on','on','安立路78号','116.414811','40.011237','近第五大道钱柜KTV，特色餐厅，中式餐厅各类美食。','2017-12-19 15:35:09','2017-12-19 15:35:09'),
	(21,NULL,'皇家大饭店','1','010-52895700',600.00,'on','4','微信','11','11','on','on','北三环东路甲6号','116.449133','39.966201','近国际展览中心旁，步行即可到达大型综合商场天虹百货。','2017-12-19 15:38:11','2017-12-19 15:38:11'),
	(22,NULL,'国际艺苑皇冠假日酒店','1','010-52895700',700.00,'on','5','微信','11','11','on','on','王府井大街48号','116.417882','39.925149','酒店位于王府井大街上，毗邻故宫。','2017-12-19 15:45:27','2017-12-19 15:45:27');

/*!40000 ALTER TABLE `hotels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invoice_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoice_orders`;

CREATE TABLE `invoice_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'openid',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机',
  `hotel` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '消费酒店',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '发票类型',
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '企业名称',
  `num` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '信用代码',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册地址',
  `bank` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '开户行',
  `banknum` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '开户行账户',
  `total` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '总价',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'openid',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '发票类型',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司名称',
  `num` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '信用代码',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册地址',
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `bank` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '开户行',
  `banknum` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '开户行账号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(5,'2014_10_12_000000_create_users_table',1),
	(6,'2014_10_12_100000_create_password_resets_table',1),
	(7,'2017_11_18_115704_entrust_setup_tables',1),
	(8,'2017_12_08_185137_create_cities_table',2),
	(9,'2017_12_08_185347_create_areas_table',2),
	(10,'2017_12_08_185627_create_busines_table',2),
	(11,'2017_12_08_185754_create_subways_table',2),
	(12,'2017_12_08_185839_create_brands_table',2),
	(13,'2017_12_08_190144_create_hotels_table',2),
	(14,'2017_12_08_190932_create_rooms_table',2),
	(15,'2017_12_08_191656_create_companies_table',2),
	(16,'2017_12_08_192007_create_wx_users_table',2),
	(17,'2017_12_08_192553_create_orders_table',3),
	(18,'2017_12_08_193105_create_coupons_table',3),
	(19,'2017_12_08_193359_create_coupon_users_table',3),
	(20,'2017_12_08_193629_create_invoices_table',3),
	(21,'2017_12_08_193839_create_invoice_orders_table',3),
	(22,'2017_12_14_000157_create_configs_table',4);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'openid',
  `hotel_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '酒店id',
  `order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单号',
  `hotelname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '酒店名称',
  `room` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '房型',
  `breakfast` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '有无早餐',
  `totime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '到店时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '离店时间',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '预订人',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '单价',
  `total` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '总价',
  `ordertime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单时间',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单状态',
  `invoice` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否需要开票',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `name` char(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table permission_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;

INSERT INTO `permission_role` (`permission_id`, `role_id`)
VALUES
	(1,1),
	(1,2),
	(2,1),
	(2,2),
	(3,1),
	(3,2),
	(4,1),
	(4,2),
	(5,1),
	(5,2),
	(6,1),
	(6,2),
	(7,1),
	(7,2),
	(7,3),
	(7,4),
	(9,1),
	(9,2),
	(9,3),
	(9,4),
	(9,5),
	(10,1),
	(10,2),
	(11,1),
	(11,2),
	(12,1),
	(12,2),
	(13,2),
	(14,2),
	(15,2),
	(19,2),
	(20,2),
	(21,2),
	(22,2),
	(23,2),
	(24,2),
	(25,2);

/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `display_name` varchar(255) NOT NULL COMMENT '菜单名称',
  `url` varchar(255) DEFAULT '' COMMENT 'url',
  `name` varchar(50) NOT NULL COMMENT '目录权限',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `sort` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;

INSERT INTO `permissions` (`id`, `img`, `display_name`, `url`, `name`, `status`, `pid`, `sort`, `description`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'酒店管理','/admin/menu','admin.menu',1,0,0,NULL,NULL,'2017-12-11 13:03:42'),
	(2,NULL,'系统设置','site/index','site.index',1,0,0,NULL,'2017-11-19 18:11:59','2017-11-21 10:48:35'),
	(3,NULL,'微信设置','wechat/index','wechat/index',1,2,0,NULL,'2017-11-20 14:41:00','2017-11-20 14:41:00'),
	(4,NULL,'微信配置','wechat/index','wechat/config',1,3,5,NULL,'2017-11-20 14:46:47','2017-12-11 14:04:42'),
	(5,NULL,'管理员管理','admin/index','admin/list',1,2,0,NULL,'2017-11-20 16:00:10','2017-11-20 16:00:10'),
	(6,NULL,'角色管理','admin/role','role/index',1,5,0,NULL,'2017-11-20 16:20:00','2017-11-21 10:57:34'),
	(7,NULL,'酒店管理','/admin/hotel/','hotel/list',1,1,0,NULL,'2017-11-20 16:21:08','2017-12-12 19:39:53'),
	(9,NULL,'酒店列表','/admin/hotel/','hotel/index',1,7,0,NULL,'2017-11-20 16:22:30','2017-12-12 19:46:37'),
	(10,NULL,'添加酒店','/admin/hotel/0','hotel/add',1,7,0,NULL,'2017-11-20 16:25:53','2017-12-12 19:40:07'),
	(11,NULL,'菜单管理',NULL,'menu/list',1,2,0,NULL,'2017-11-20 17:20:35','2017-11-20 17:20:35'),
	(12,NULL,'菜单列表','admin/menu','admin/menu',1,11,0,NULL,'2017-11-20 17:21:13','2017-11-20 17:21:13'),
	(13,NULL,'添加菜单','admin/menu/0','admin/menu/add',1,11,0,NULL,'2017-11-20 17:22:15','2017-11-20 17:22:15'),
	(14,NULL,'添加角色','/admin/role/0','role.add',1,5,0,NULL,'2017-11-21 17:17:34','2017-11-21 17:17:34'),
	(15,NULL,'管理员列表','admin/admins/','admin/admins',1,5,1,NULL,'2017-11-21 17:20:12','2017-11-21 17:20:28'),
	(19,NULL,'城市管理','/admin/province','1512985746',1,20,0,NULL,'2017-12-11 17:49:06','2017-12-18 16:55:19'),
	(20,NULL,'基础设置',NULL,'1512985808',1,1,0,NULL,'2017-12-11 17:50:08','2017-12-11 17:50:08'),
	(21,NULL,'设施服务','admin/service','1513181415',1,20,0,NULL,'2017-12-14 00:10:15','2017-12-14 00:10:15'),
	(22,NULL,'公司管理','/admin/company','1513476638',1,20,0,NULL,'2017-12-17 10:10:38','2017-12-17 10:10:38'),
	(23,NULL,'会员管理','/admin/user','1513524022',1,24,0,NULL,'2017-12-17 23:20:22','2017-12-17 23:45:25'),
	(24,NULL,'会员',NULL,'1513525517',1,1,0,NULL,'2017-12-17 23:45:17','2017-12-17 23:45:17'),
	(25,NULL,'会员等级设置','/admin/grade','1513525575',1,24,0,NULL,'2017-12-17 23:46:15','2017-12-17 23:46:15');

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;

INSERT INTO `role_user` (`user_id`, `role_id`)
VALUES
	(1,2);

/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'1511236376','123','222212111','2017-11-21 11:52:56','2017-11-21 17:03:50'),
	(2,'1511254930','超级管理员','很厉害的','2017-11-21 17:02:10','2017-12-17 23:46:23'),
	(3,'1511255021','很厉害的管理','厉害的很','2017-11-21 17:03:41','2017-11-21 17:03:41'),
	(4,'1511255038','1121','212121','2017-11-21 17:03:58','2017-11-21 17:03:58'),
	(5,'1511255867','adadsads','dsqadqs','2017-11-21 17:17:47','2017-11-21 17:17:47');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table rooms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL COMMENT '酒店id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '房型名称',
  `price` double(10,2) NOT NULL COMMENT '门市价格',
  `memberprice` double(10,2) DEFAULT NULL COMMENT '会员价',
  `period` int(11) DEFAULT NULL COMMENT '预订周期',
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '面积',
  `bedwidth` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '床宽',
  `window` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '窗户',
  `breakfast` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '早餐',
  `bedstyle` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '床型',
  `floors` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '楼层',
  `num` int(11) DEFAULT NULL COMMENT '入住人数',
  `Internet` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '上网方式',
  `nonsmok` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '无烟房',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '备注',
  `img` text COLLATE utf8_unicode_ci COMMENT '图片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;

INSERT INTO `rooms` (`id`, `hotel_id`, `name`, `price`, `memberprice`, `period`, `area`, `bedwidth`, `window`, `breakfast`, `bedstyle`, `floors`, `num`, `Internet`, `nonsmok`, `remark`, `img`, `created_at`, `updated_at`)
VALUES
	(1,1,'标准房1',108.00,100.00,2,'10','1.2','没有','没有','大床','29',2,'wifi','否','好房子','avatars/oPsA3gO8cCy7p7BzSlk6tUyCYxpwlqdI2KVZFIeg.jpeg','2017-12-14 04:52:55','2017-12-14 05:01:05'),
	(3,3,'大房间',100.00,90.00,5,'20','1.2','有','有','大床','1',1,'wifi','是','12','avatars/f5YFfVIqPiylXoCJpJtvqh9nsXFqEENnSkzHDTGc.jpeg','2017-12-18 17:49:04','2017-12-18 17:49:04'),
	(4,7,'1221',122.00,NULL,NULL,NULL,NULL,'有','有',NULL,NULL,NULL,NULL,'是',NULL,'','2017-12-19 12:16:31','2017-12-19 12:16:31'),
	(5,7,'212121',2112.00,NULL,NULL,NULL,NULL,'有','有',NULL,NULL,NULL,NULL,'是',NULL,'','2017-12-19 12:17:12','2017-12-19 12:17:12');

/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subways
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subways`;

CREATE TABLE `subways` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `subways` WRITE;
/*!40000 ALTER TABLE `subways` DISABLE KEYS */;

INSERT INTO `subways` (`id`, `city_id`, `value`, `created_at`, `updated_at`)
VALUES
	(1,1,'13号线','2017-12-11 21:05:37','2017-12-11 21:05:37'),
	(2,1,'1号线','2017-12-11 21:05:42','2017-12-11 21:05:42'),
	(3,1,'2号线','2017-12-11 21:05:47','2017-12-11 21:05:47'),
	(4,3,'1号线','2017-12-11 21:06:19','2017-12-11 21:06:19'),
	(5,3,'2号线','2017-12-11 21:06:24','2017-12-11 21:06:24'),
	(6,1,'3号线','2017-12-11 21:09:41','2017-12-11 21:09:48'),
	(7,5,'121212121212','2017-12-14 10:40:20','2017-12-14 10:40:20'),
	(10,11,'1号线','2017-12-19 11:45:17','2017-12-19 11:45:17'),
	(11,11,'2号线','2017-12-19 11:45:26','2017-12-19 11:45:26'),
	(12,11,'4号线','2017-12-19 11:45:32','2017-12-19 11:45:32'),
	(13,11,'5号线','2017-12-19 11:45:39','2017-12-19 11:45:39'),
	(14,11,'6号线','2017-12-19 11:45:46','2017-12-19 11:45:46'),
	(15,11,'7号线','2017-12-19 11:45:54','2017-12-19 11:45:54'),
	(16,11,'8号线','2017-12-19 11:46:01','2017-12-19 11:46:01'),
	(17,11,'9号线','2017-12-19 11:46:07','2017-12-19 11:46:07'),
	(18,11,'10号线','2017-12-19 11:46:14','2017-12-19 11:46:32'),
	(19,11,'13号线','2017-12-19 11:46:40','2017-12-19 11:46:40'),
	(20,11,'14号线','2017-12-19 11:46:50','2017-12-19 11:46:50'),
	(21,11,'15号线','2017-12-19 11:46:58','2017-12-19 11:46:58'),
	(22,11,'机场线','2017-12-19 12:28:59','2017-12-19 12:28:59'),
	(23,11,'无地铁','2017-12-19 12:37:34','2017-12-19 12:37:34'),
	(24,11,'亦庄线','2017-12-19 15:31:52','2017-12-19 15:31:52'),
	(25,11,'昌平线','2017-12-19 15:32:03','2017-12-19 15:32:03');

/*!40000 ALTER TABLE `subways` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL COMMENT '类型',
  `name` char(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT '姓名',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `wxuser_id` int(11) DEFAULT NULL COMMENT 'wechat_id',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `type`, `name`, `email`, `password`, `nickname`, `status`, `wxuser_id`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'admin','admin','admin','b3a633dab7e0b9cd5079da44b19581a88dfdf398','超级管理员1',1,NULL,NULL,NULL,'2017-11-22 16:29:32');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table wx_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `wx_users`;

CREATE TABLE `wx_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司id',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '姓名',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号',
  `sex` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '性别',
  `grade` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '等级',
  `exception` int(255) NOT NULL DEFAULT '0' COMMENT '是否白名单',
  `autoex` int(255) NOT NULL DEFAULT '0' COMMENT '是否自动升级',
  `integral` double(20,2) DEFAULT '0.00' COMMENT '积分',
  `total` double(20,2) DEFAULT '0.00' COMMENT '总消费金额',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '邮箱',
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '公司',
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '区域',
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '部门',
  `duty` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '职务',
  `ide` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '证件类型',
  `idenum` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '身份证号码',
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'openid',
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '微信昵称',
  `headimgurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '头像路径',
  `groupid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '分组',
  `unionid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'unionid',
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `wx_users` WRITE;
/*!40000 ALTER TABLE `wx_users` DISABLE KEYS */;

INSERT INTO `wx_users` (`id`, `company_id`, `name`, `phone`, `sex`, `grade`, `exception`, `autoex`, `integral`, `total`, `email`, `company`, `area`, `department`, `duty`, `ide`, `idenum`, `openid`, `nickname`, `headimgurl`, `groupid`, `unionid`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'13213212','孙晓俊','18310031093','1','',0,1,0.00,0.00,'','','','','','','','','','','','','',NULL,NULL);

/*!40000 ALTER TABLE `wx_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
