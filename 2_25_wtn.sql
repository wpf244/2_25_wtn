# Host: localhost  (Version: 5.5.53)
# Date: 2019-03-15 14:25:36
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ddsc_addr"
#

DROP TABLE IF EXISTS `ddsc_addr`;
CREATE TABLE `ddsc_addr` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(255) DEFAULT NULL COMMENT '用户id',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `addrs` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `username` varchar(255) DEFAULT NULL COMMENT '姓名',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `default` tinyint(3) NOT NULL DEFAULT '0' COMMENT '默认收货地址 0否 1是',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='收货地址';

#
# Data for table "ddsc_addr"
#

/*!40000 ALTER TABLE `ddsc_addr` DISABLE KEYS */;
INSERT INTO `ddsc_addr` VALUES (1,'6','河南省郑州市金水区','恒华大厦806','王鹏飞159','15939590207',0);
/*!40000 ALTER TABLE `ddsc_addr` ENABLE KEYS */;

#
# Structure for table "ddsc_admin"
#

DROP TABLE IF EXISTS `ddsc_admin`;
CREATE TABLE `ddsc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `pretime` datetime DEFAULT NULL,
  `curtime` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL COMMENT '登录IP',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '管理员类型 0超级管理员 1普通管理员',
  `control` text COMMENT '控制器权限',
  `way` text COMMENT '方法',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_admin"
#

/*!40000 ALTER TABLE `ddsc_admin` DISABLE KEYS */;
INSERT INTO `ddsc_admin` VALUES (1,'admin','8a30ec6807f71bc69d096d8e4d501ade','2019-03-14 09:15:39','2019-03-15 08:55:10','0.0.0.0',0,NULL,NULL);
/*!40000 ALTER TABLE `ddsc_admin` ENABLE KEYS */;

#
# Structure for table "ddsc_advise"
#

DROP TABLE IF EXISTS `ddsc_advise`;
CREATE TABLE `ddsc_advise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `content` text COMMENT '留言内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "ddsc_advise"
#

/*!40000 ALTER TABLE `ddsc_advise` DISABLE KEYS */;
INSERT INTO `ddsc_advise` VALUES (1,6,'意见与反馈');
/*!40000 ALTER TABLE `ddsc_advise` ENABLE KEYS */;

#
# Structure for table "ddsc_assess"
#

DROP TABLE IF EXISTS `ddsc_assess`;
CREATE TABLE `ddsc_assess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `u_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `number` tinyint(3) NOT NULL DEFAULT '0' COMMENT '几颗星',
  `content` text COMMENT '内容',
  `addtime` varchar(255) DEFAULT NULL COMMENT '评论时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否审核 0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品评价';

#
# Data for table "ddsc_assess"
#

/*!40000 ALTER TABLE `ddsc_assess` DISABLE KEYS */;
INSERT INTO `ddsc_assess` VALUES (2,18,6,4,'123','1545463701',1),(3,18,6,4,'123','1545463701',1),(4,18,6,4,'123','1545463701',1),(5,18,6,4,'123','1545463701',1),(6,18,6,4,'123','1545463701',1),(7,18,6,4,'123','1545463701',1);
/*!40000 ALTER TABLE `ddsc_assess` ENABLE KEYS */;

#
# Structure for table "ddsc_car"
#

DROP TABLE IF EXISTS `ddsc_car`;
CREATE TABLE `ddsc_car` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) DEFAULT NULL COMMENT '用户id',
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `num` int(11) DEFAULT NULL COMMENT '商品数量',
  `c_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `c_image` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `price` float(16,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '选中状态 0否 1是',
  `s_id` int(11) DEFAULT NULL COMMENT '规格id',
  `s_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='购物车';

#
# Data for table "ddsc_car"
#

/*!40000 ALTER TABLE `ddsc_car` DISABLE KEYS */;
INSERT INTO `ddsc_car` VALUES (8,6,18,2,'就的撒恐龙当家','/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',100.00,0,2,'规格1',0),(10,6,17,2,'就的撒恐龙当家','/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',100.00,0,2,'规格1',0),(14,41,18,1,'就的撒恐龙当家','/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',100.00,0,2,'规格1',0),(35,40,19,15,'个梵蒂冈','/uploads/20190228/9242cc228bde23d8c2aa4bb37ef72592.png',100.00,1,5,'规格2',2),(36,40,18,5,'就的撒恐龙当家','/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',200.00,1,3,'规格2',0);
/*!40000 ALTER TABLE `ddsc_car` ENABLE KEYS */;

#
# Structure for table "ddsc_car_dd"
#

DROP TABLE IF EXISTS `ddsc_car_dd`;
CREATE TABLE `ddsc_car_dd` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `gid` int(11) DEFAULT NULL COMMENT '商品id',
  `price` float(16,2) NOT NULL DEFAULT '0.01' COMMENT '商品单价',
  `num` int(11) DEFAULT NULL COMMENT '商品数量',
  `zprice` float(16,2) NOT NULL DEFAULT '0.01' COMMENT '商品总价',
  `g_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `g_image` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品状态 0已提交 1已确定 2已支付',
  `code` varchar(255) DEFAULT NULL COMMENT '订单编号',
  `pay` text COMMENT '总订单编号',
  `time` char(20) DEFAULT NULL COMMENT '提交时间',
  `a_id` int(11) DEFAULT NULL COMMENT '收货地址id',
  `content` text COMMENT '订单留言',
  `fa_time` varchar(255) DEFAULT NULL COMMENT '发货时间',
  `s_name` varchar(255) DEFAULT NULL COMMENT '商品规格',
  `pay_type` int(1) NOT NULL DEFAULT '0' COMMENT '支付方式 0微信支付 1股金支付',
  `tui_content` text COMMENT '退货原因',
  `tui_time` varchar(220) DEFAULT NULL COMMENT '申请退货时间',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `freight` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `fu_time` varchar(255) DEFAULT NULL COMMENT '付款时间',
  `end_time` varchar(255) DEFAULT NULL COMMENT '完成时间',
  `reason` varchar(255) DEFAULT NULL COMMENT '订单取消原因',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单表';

#
# Data for table "ddsc_car_dd"
#

/*!40000 ALTER TABLE `ddsc_car_dd` DISABLE KEYS */;
INSERT INTO `ddsc_car_dd` VALUES (4,6,-1,0.01,1,410.00,'就的撒恐龙当家就的撒恐龙当家',NULL,0,'AKS-5c80c651a4440a','AK-5c80c651a4058a,CK-5c80c6519dac6,CK-5c80c651a3c70','1551943249',1,NULL,NULL,NULL,0,NULL,NULL,0,0.00,NULL,NULL,NULL),(5,6,19,100.00,2,200.00,'个梵蒂冈','/uploads/20190228/9242cc228bde23d8c2aa4bb37ef72592.png',6,'CK-5c80c66cc6d30',NULL,'1551943276',1,NULL,'1552358061','规格2',0,'内容','1552358754',2,0.00,NULL,NULL,'原因'),(6,6,16,100.00,2,200.00,'个梵蒂冈','/uploads/20190228/9242cc228bde23d8c2aa4bb37ef72592.png',6,'CK-5c80c66ccd2c2',NULL,'1551943276',1,NULL,'1552358061','规格2',0,'内容','1552358754',2,0.00,NULL,NULL,'原因'),(7,6,0,0.01,1,400.00,'个梵蒂冈个梵蒂冈',NULL,6,'AK-5c80c66ccd6aaa','CK-5c80c66cc6d30,CK-5c80c66ccd2c2','1551943276',1,NULL,'1552358061',NULL,0,'内容','1552358754',2,0.00,NULL,NULL,'原因'),(8,6,-1,0.01,1,400.00,'个梵蒂冈个梵蒂冈',NULL,0,'AKS-5c80c66ccda92a','AK-5c80c66ccd6aaa,CK-5c80c66cc6d30,CK-5c80c66ccd2c2','1551943276',1,NULL,NULL,NULL,0,NULL,NULL,0,0.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ddsc_car_dd` ENABLE KEYS */;

#
# Structure for table "ddsc_carte"
#

DROP TABLE IF EXISTS `ddsc_carte`;
CREATE TABLE `ddsc_carte` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `c_modul` varchar(255) DEFAULT NULL COMMENT '控制器',
  `c_icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `c_sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_carte"
#

/*!40000 ALTER TABLE `ddsc_carte` DISABLE KEYS */;
INSERT INTO `ddsc_carte` VALUES (1,'网站设置','Sys','fa-desktop',0,1),(2,'基本信息','seting','',1,50),(3,'网站优化','seo','',1,50),(4,'广告管理','Lb','fa-picture-o',0,2),(5,'广告列表','lister','',4,50),(6,'广告位','place','',4,50),(13,'菜单管理','Carte','fa-reorder',0,3),(14,'后台模板','lister','',13,50),(16,'管理员管理','User','fa-user',0,4),(17,'管理员列表','lister','',16,50),(19,'会员管理','Member','fa-address-book-o',0,5),(20,'会员列表','lister','',19,50),(34,'日志管理','Log','fa-book',0,12),(36,'后台登录日志','index','',34,50),(39,'订单管理','Dd','fa-paper-plane',0,7),(40,'待付款订单','dai_dd','',39,50),(41,'待发货订单','fa_dd','',39,50),(42,'待收货订单','shou_dd','',39,50),(43,'待评价订单','ping_dd','',39,50),(44,'已完成订单','wan_dd','',39,50),(45,'商品管理','Goods','fa-map-signs',0,6),(46,'商品列表','lister','',45,50),(47,'商品分类','type','',45,50),(48,'评论管理','Assess','fa-area-chart',0,50),(58,'未审核评论','lister','',48,50),(59,'已审核评论','index','',48,50),(62,'意见反馈','Message','fa-desktop',0,50),(63,'反馈列表','lister','',62,50),(67,'申请退货列表','tui_dd','',39,50),(68,'已退货列表','ytui_dd','',39,50),(69,'店铺管理','Shop','fa-flag',0,8),(70,'店铺列表','lister','',69,50),(71,'待审核商品','index','',45,50),(74,'快递柜管理','Sark','fa-cube',0,10),(75,'快递柜列表','lister','',74,50),(78,'免费次数','free','',74,50),(79,'开柜金额','money','',74,50),(80,'赠送积分','sales','',74,50);
/*!40000 ALTER TABLE `ddsc_carte` ENABLE KEYS */;

#
# Structure for table "ddsc_code"
#

DROP TABLE IF EXISTS `ddsc_code`;
CREATE TABLE `ddsc_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `code` char(6) DEFAULT NULL COMMENT '验证码',
  `time` varchar(255) DEFAULT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='验证码';

#
# Data for table "ddsc_code"
#

/*!40000 ALTER TABLE `ddsc_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `ddsc_code` ENABLE KEYS */;

#
# Structure for table "ddsc_collect"
#

DROP TABLE IF EXISTS `ddsc_collect`;
CREATE TABLE `ddsc_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0',
  `g_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='商品收藏';

#
# Data for table "ddsc_collect"
#

/*!40000 ALTER TABLE `ddsc_collect` DISABLE KEYS */;
INSERT INTO `ddsc_collect` VALUES (1,6,18),(9,40,17),(22,40,18),(23,41,18),(26,40,19),(27,40,6);
/*!40000 ALTER TABLE `ddsc_collect` ENABLE KEYS */;

#
# Structure for table "ddsc_courier"
#

DROP TABLE IF EXISTS `ddsc_courier`;
CREATE TABLE `ddsc_courier` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '所属区域id',
  `eid` int(11) NOT NULL DEFAULT '0' COMMENT '所属公司id',
  `name` varchar(255) DEFAULT NULL COMMENT '快递员姓名',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='快递员列表';

#
# Data for table "ddsc_courier"
#

/*!40000 ALTER TABLE `ddsc_courier` DISABLE KEYS */;
INSERT INTO `ddsc_courier` VALUES (3,3,3,'王鹏飞','15939590207','2019-03-13 15:13:48');
/*!40000 ALTER TABLE `ddsc_courier` ENABLE KEYS */;

#
# Structure for table "ddsc_express"
#

DROP TABLE IF EXISTS `ddsc_express`;
CREATE TABLE `ddsc_express` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `ex_addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `ex_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '公司状态 0关闭 1开启',
  `ex_time` varchar(255) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='快递公司';

#
# Data for table "ddsc_express"
#

/*!40000 ALTER TABLE `ddsc_express` DISABLE KEYS */;
INSERT INTO `ddsc_express` VALUES (2,'顺丰快递','郑州市金水区1',1,'2019-03-12 15:20:40'),(3,'韵达快递','郑州市中原区1',1,'2019-03-13 11:07:48');
/*!40000 ALTER TABLE `ddsc_express` ENABLE KEYS */;

#
# Structure for table "ddsc_express_dd"
#

DROP TABLE IF EXISTS `ddsc_express_dd`;
CREATE TABLE `ddsc_express_dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0待支付 1已支付 2已取件',
  `time` varchar(255) DEFAULT NULL COMMENT '下单时间',
  `code` varchar(255) DEFAULT NULL COMMENT '订单号',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '订单类型 0业主 1其他人',
  `money` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `number` varchar(255) DEFAULT NULL COMMENT '柜子编号',
  `f_time` varchar(255) DEFAULT NULL COMMENT '快递放入时间',
  `q_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '取件人id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='寄件订单';

#
# Data for table "ddsc_express_dd"
#

/*!40000 ALTER TABLE `ddsc_express_dd` DISABLE KEYS */;
INSERT INTO `ddsc_express_dd` VALUES (2,6,2,'1552534689','20190314113809',0,1.00,'001','1552555723',0),(3,6,2,'1552534689','20190314113809',0,1.00,'001','1552555819',0),(4,6,3,'1552534689','20190314113809',1,1.00,'001',NULL,0);
/*!40000 ALTER TABLE `ddsc_express_dd` ENABLE KEYS */;

#
# Structure for table "ddsc_free"
#

DROP TABLE IF EXISTS `ddsc_free`;
CREATE TABLE `ddsc_free` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` float(16,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='免费次数';

#
# Data for table "ddsc_free"
#

/*!40000 ALTER TABLE `ddsc_free` DISABLE KEYS */;
INSERT INTO `ddsc_free` VALUES (1,10.00),(2,1.00),(3,10.00);
/*!40000 ALTER TABLE `ddsc_free` ENABLE KEYS */;

#
# Structure for table "ddsc_goods"
#

DROP TABLE IF EXISTS `ddsc_goods`;
CREATE TABLE `ddsc_goods` (
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `g_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `g_xprice` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '商品现价',
  `g_sales` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `g_kc` int(11) DEFAULT NULL COMMENT '库存',
  `g_content` text COMMENT '商品详情',
  `g_up` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品状态 0下架 1上架',
  `g_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页显示 0否 1是',
  `g_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `g_image` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `fid` int(11) DEFAULT NULL COMMENT '所属分类id',
  `spec` text COMMENT '商品规格',
  `desc` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `tag` varchar(255) DEFAULT NULL COMMENT '商品标签',
  `g_images` varchar(255) DEFAULT NULL COMMENT '首页推荐图',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `g_freight` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `g_audi` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否审核 0否 1是',
  `g_thumb` varchar(255) DEFAULT NULL COMMENT '推荐图125',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_goods"
#

/*!40000 ALTER TABLE `ddsc_goods` DISABLE KEYS */;
INSERT INTO `ddsc_goods` VALUES (2,'测试11',22.00,1,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/e3e64b25d62d037b3fedae1244437b94.png',1,'','商品描述','标签1@标签2','/thumb/5c774f6a195e40.52800350.jpg',0,0.00,1,'/thumb/cd8ab9d7637859a571d2f4fc3fda9c69.jpg'),(3,'测试11',12.00,2,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/4008214c7a9306c52ab6b801ef25ae57.png',1,'','商品描述','标签1@标签2','/thumb/5c774f6090dd47.62358795.jpg',0,0.00,1,'/thumb/22df999604d98394b0ae33dde22b07c1.jpg'),(4,'测试11',25.00,3,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/26e5dd8fd554cf3197fa1d7d7579d438.png',1,'','商品描述','标签1@标签2','/thumb/5c774f57d49d16.11538929.jpg',0,0.00,1,'/thumb/26e22d53778cd27ced003ff58f8bad1a.jpg'),(5,'测试11',23.00,4,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/91bc12bb2a6ff0ae9e05fbadb03822e8.png',1,'','商品描述','标签1@标签2','/thumb/5c774f4bdbc551.04242419.jpg',0,0.00,1,'/thumb/f3833c7e664c7ce6fc382506ad4fca40.jpg'),(6,'测试11',52.00,5,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(7,'测试11',45.00,6,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(8,'测试11',57.00,7,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(9,'测试11',456.00,8,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(10,'测试11',5454.00,9,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',3,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(17,'测试11',231.00,10,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/24571df92ed07f927c62843e720e3e50.png',3,'','商品描述','标签1@标签2','/thumb/5c774f4256d331.23641077.jpg',0,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(18,'就的撒恐龙当家',111.00,1111,111,'<p><img src=\"/ueditor/php/upload/image/20190227/1551238744.png\" title=\"1551238744.png\" alt=\"8842d10cb9a04371f43452b69fd19e0a.png\"/></p>',1,1,50,'/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',3,NULL,'商品描述','标签1@标签2','/thumb/5c774f29465c97.34530779.jpg',0,10.00,1,'/thumb/0987b3b1fd48498e517ae3f4fb0a21f9.jpg'),(19,'个梵蒂冈',11111.00,111,111,'<p>是非得失</p>',1,1,50,'/uploads/20190228/9242cc228bde23d8c2aa4bb37ef72592.png',3,NULL,'商品描述','标签1@标签2','/thumb/5c774f7793df06.47104837.jpg',2,0.00,1,'/thumb/41d354d9b6ac98e54aa58c7de88b0082.jpg');
/*!40000 ALTER TABLE `ddsc_goods` ENABLE KEYS */;

#
# Structure for table "ddsc_goods_img"
#

DROP TABLE IF EXISTS `ddsc_goods_img`;
CREATE TABLE `ddsc_goods_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `i_status` tinyint(3) NOT NULL DEFAULT '0',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品多图';

#
# Data for table "ddsc_goods_img"
#

/*!40000 ALTER TABLE `ddsc_goods_img` DISABLE KEYS */;
INSERT INTO `ddsc_goods_img` VALUES (1,'/uploads/20190226/4c30067a1abb79abf9c59d783388d83d.png',1,NULL,1,NULL),(2,'/uploads/20190306/131ca1fa85f52b1c3e1d55b3176c3947.png',18,NULL,1,NULL),(3,'/uploads/20190306/4e905de7b8735ae096b0e5b48f1e94d8.png',18,NULL,1,NULL);
/*!40000 ALTER TABLE `ddsc_goods_img` ENABLE KEYS */;

#
# Structure for table "ddsc_goods_spec"
#

DROP TABLE IF EXISTS `ddsc_goods_spec`;
CREATE TABLE `ddsc_goods_spec` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `s_name` varchar(255) DEFAULT NULL COMMENT '规格名称',
  `s_xprice` float(16,2) DEFAULT NULL COMMENT '价格',
  `s_sort` int(11) DEFAULT NULL COMMENT '排序',
  `s_image` varchar(255) DEFAULT NULL COMMENT '图片',
  `s_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '规格状态 0禁用 1启用',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品规格';

#
# Data for table "ddsc_goods_spec"
#

/*!40000 ALTER TABLE `ddsc_goods_spec` DISABLE KEYS */;
INSERT INTO `ddsc_goods_spec` VALUES (1,1,'规格1',100.00,NULL,'/uploads/20190226/89737924e1f3d9ee0c4528b716e36b2f.png',1),(2,18,'规格1',100.00,NULL,'/uploads/20190306/386dac2b3f626f004e2b3a322a69c765.png',1),(3,18,'规格2',200.00,NULL,'/uploads/20190307/851d86f8d15f5917c81d893b3db7536e.png',1),(4,17,'规格1',100.00,NULL,'/uploads/20190306/9b47cc27fbeee96f5092d3445f5ee9c7.png',1),(5,19,'规格2',100.00,NULL,'/uploads/20190306/6caafa9ae89ed5ffd2b8b630e7112766.png',1);
/*!40000 ALTER TABLE `ddsc_goods_spec` ENABLE KEYS */;

#
# Structure for table "ddsc_hot"
#

DROP TABLE IF EXISTS `ddsc_hot`;
CREATE TABLE `ddsc_hot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(255) DEFAULT NULL COMMENT '热门推荐',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0关闭 1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='店铺热门推荐';

#
# Data for table "ddsc_hot"
#

/*!40000 ALTER TABLE `ddsc_hot` DISABLE KEYS */;
INSERT INTO `ddsc_hot` VALUES (2,2,'哈哈1',1),(3,2,'测试',1);
/*!40000 ALTER TABLE `ddsc_hot` ENABLE KEYS */;

#
# Structure for table "ddsc_lb"
#

DROP TABLE IF EXISTS `ddsc_lb`;
CREATE TABLE `ddsc_lb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL COMMENT '父类id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态0关闭 1开启',
  `url` varchar(255) DEFAULT NULL,
  `desc` text COMMENT '简介',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告列表';

#
# Data for table "ddsc_lb"
#

/*!40000 ALTER TABLE `ddsc_lb` DISABLE KEYS */;
INSERT INTO `ddsc_lb` VALUES (1,1,'如何查询为取快递',50,1,'','<p>如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递</p>',NULL,NULL),(2,2,'寄快递如何下单',50,1,'','<p>寄快递如何下单寄快递如何下单寄快递如何下单寄快递如何下单寄快递如何下单</p>',NULL,NULL),(3,2,'如何支付运费',50,1,'','<p>如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费</p>',NULL,NULL),(4,3,'banner',50,1,'','','/uploads/20190228/3f943c45fc09d29b01eed0ffe94605ad.png',NULL),(5,3,'banner',50,1,'','','/uploads/20190228/a3e900c27e097d73976785ec9f299055.png',NULL),(6,4,'海报',50,1,'','','/uploads/20190228/4d1d95c5c510e2d6860c22d7a90b61fe.png',NULL),(7,5,'banner',50,1,'','','/uploads/20190228/97d00315ef69824ee1b94a615d417a60.png',NULL),(8,6,'我不想买了',50,1,'','',NULL,NULL),(9,6,'信息填写错误,重新买',50,1,'','',NULL,NULL),(10,6,'卖家缺货',50,1,'','',NULL,NULL),(11,6,'运费不合适',50,1,'','',NULL,NULL),(12,6,'其他',50,1,'','',NULL,NULL),(13,7,'商城上线了',50,1,'','',NULL,NULL),(14,7,'商城公告啊',50,1,'','',NULL,NULL);
/*!40000 ALTER TABLE `ddsc_lb` ENABLE KEYS */;

#
# Structure for table "ddsc_lb_place"
#

DROP TABLE IF EXISTS `ddsc_lb_place`;
CREATE TABLE `ddsc_lb_place` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播id',
  `pl_name` varchar(255) DEFAULT NULL COMMENT '位置名称',
  PRIMARY KEY (`pl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位';

#
# Data for table "ddsc_lb_place"
#

/*!40000 ALTER TABLE `ddsc_lb_place` DISABLE KEYS */;
INSERT INTO `ddsc_lb_place` VALUES (1,'帮助中心取快递'),(2,'帮助中心寄快递'),(3,'首页banner'),(4,'首页海报'),(5,'更多优惠banner'),(6,'订单取消原因'),(7,'商城公告');
/*!40000 ALTER TABLE `ddsc_lb_place` ENABLE KEYS */;

#
# Structure for table "ddsc_mailing_addr"
#

DROP TABLE IF EXISTS `ddsc_mailing_addr`;
CREATE TABLE `ddsc_mailing_addr` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(255) DEFAULT NULL COMMENT '寄件人姓名',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '地址类型 0寄件地址 1收件地址',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='寄件地址';

#
# Data for table "ddsc_mailing_addr"
#

/*!40000 ALTER TABLE `ddsc_mailing_addr` DISABLE KEYS */;
INSERT INTO `ddsc_mailing_addr` VALUES (3,6,'王鹏飞寄件地址','159395902076','河南省郑州市金水区恒华大厦1',0),(4,6,'王鹏飞收件地址','159395902076','河南省郑州市金水区恒华大厦1',1);
/*!40000 ALTER TABLE `ddsc_mailing_addr` ENABLE KEYS */;

#
# Structure for table "ddsc_sark"
#

DROP TABLE IF EXISTS `ddsc_sark`;
CREATE TABLE `ddsc_sark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL COMMENT '快递柜标号',
  `addr` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `phone` text COMMENT '绑定手机号',
  `time` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '柜子状态 0不能开 1能开',
  `user_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户控制状态 0不能开 1能开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='快递柜';

#
# Data for table "ddsc_sark"
#

/*!40000 ALTER TABLE `ddsc_sark` DISABLE KEYS */;
INSERT INTO `ddsc_sark` VALUES (2,'001','郑州市金水区花园路与国基路北200米恒华大厦8楼','15939590207@15939590206','2019-03-12 17:29:37',0,0),(3,'002','河南省郑州市二七区赣江路163号','16603829557','2019-03-12 17:32:27',1,0);
/*!40000 ALTER TABLE `ddsc_sark` ENABLE KEYS */;

#
# Structure for table "ddsc_sark_addr"
#

DROP TABLE IF EXISTS `ddsc_sark_addr`;
CREATE TABLE `ddsc_sark_addr` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(255) DEFAULT NULL,
  `a_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='区域列表';

#
# Data for table "ddsc_sark_addr"
#

/*!40000 ALTER TABLE `ddsc_sark_addr` DISABLE KEYS */;
INSERT INTO `ddsc_sark_addr` VALUES (2,'郑东新区','2019-03-12 15:57:04'),(3,'金水区','2019-03-12 16:39:22');
/*!40000 ALTER TABLE `ddsc_sark_addr` ENABLE KEYS */;

#
# Structure for table "ddsc_seo"
#

DROP TABLE IF EXISTS `ddsc_seo`;
CREATE TABLE `ddsc_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '首页标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `description` text COMMENT 'seo描述',
  `copy` text COMMENT '版权信息',
  `code` text COMMENT '统计代码',
  `support` varchar(255) DEFAULT NULL COMMENT '技术支持',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站优化';

#
# Data for table "ddsc_seo"
#

/*!40000 ALTER TABLE `ddsc_seo` DISABLE KEYS */;
INSERT INTO `ddsc_seo` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ddsc_seo` ENABLE KEYS */;

#
# Structure for table "ddsc_shop"
#

DROP TABLE IF EXISTS `ddsc_shop`;
CREATE TABLE `ddsc_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `content` text COMMENT '店铺简介',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `username` char(20) DEFAULT NULL COMMENT '账号',
  `pwd` char(20) DEFAULT NULL COMMENT '登录密码',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态 0关闭 1开启',
  `goods_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品免审核 0否 1是',
  `image` varchar(255) DEFAULT NULL COMMENT '店铺banner',
  `follow` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='店铺列表';

#
# Data for table "ddsc_shop"
#

/*!40000 ALTER TABLE `ddsc_shop` DISABLE KEYS */;
INSERT INTO `ddsc_shop` VALUES (2,'测试案例11','/uploads/20190226/9dfb1dc67a60a3d52914a3c1aae47aae.png','<p><img src=\"/ueditor/php/upload/image/20190227/1551239645.png\" title=\"1551239645.png\" alt=\"238497764497162650.png\"/></p>','2019-02-26 11:41:09','15939590206','zhangsan','666666',1,0,'/uploads/20190228/c8402f9f5b5a4b99a8e5df9eaa2eb641.png',0);
/*!40000 ALTER TABLE `ddsc_shop` ENABLE KEYS */;

#
# Structure for table "ddsc_shop_collect"
#

DROP TABLE IF EXISTS `ddsc_shop_collect`;
CREATE TABLE `ddsc_shop_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='店铺收藏列表';

#
# Data for table "ddsc_shop_collect"
#

/*!40000 ALTER TABLE `ddsc_shop_collect` DISABLE KEYS */;
INSERT INTO `ddsc_shop_collect` VALUES (4,40,2),(5,6,2),(6,6,0),(7,41,0);
/*!40000 ALTER TABLE `ddsc_shop_collect` ENABLE KEYS */;

#
# Structure for table "ddsc_sys"
#

DROP TABLE IF EXISTS `ddsc_sys`;
CREATE TABLE `ddsc_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `username` varchar(255) DEFAULT NULL COMMENT '负责人',
  `url` varchar(255) DEFAULT NULL COMMENT '网站域名',
  `qq` char(20) DEFAULT NULL COMMENT '客服QQ',
  `icp` varchar(255) DEFAULT NULL COMMENT 'icp备案号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(255) DEFAULT NULL COMMENT '固定电话',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `longs` varchar(255) DEFAULT NULL COMMENT '经度',
  `lats` varchar(255) DEFAULT NULL COMMENT '纬度',
  `addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `content` text COMMENT '公司简介',
  `pclogo` varchar(255) DEFAULT NULL COMMENT '电脑端logo',
  `waplogo` varchar(255) DEFAULT NULL COMMENT '手机端logo',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '微信二维码',
  `wx` varchar(255) DEFAULT NULL COMMENT '微信公众号',
  `fax` varchar(255) DEFAULT NULL COMMENT '公司传真',
  `telphone` varchar(255) DEFAULT NULL COMMENT '400电话',
  `follow` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站基本信息';

#
# Data for table "ddsc_sys"
#

/*!40000 ALTER TABLE `ddsc_sys` DISABLE KEYS */;
INSERT INTO `ddsc_sys` VALUES (1,'威特浓网络科技','','','','','','','','','','','<p>关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊</p>','/uploads/20190301/790436fdff3b5ebab4f3979d993ff901.jpg','/uploads/20190228/9796e98f454a863a18ec19058b9c957d.png',NULL,NULL,'','',2);
/*!40000 ALTER TABLE `ddsc_sys` ENABLE KEYS */;

#
# Structure for table "ddsc_sys_log"
#

DROP TABLE IF EXISTS `ddsc_sys_log`;
CREATE TABLE `ddsc_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `time` datetime DEFAULT NULL COMMENT '操作时间',
  `admin` varchar(255) DEFAULT NULL COMMENT '操作账号',
  `ip` varchar(255) DEFAULT NULL COMMENT 'IP地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统日志';

#
# Data for table "ddsc_sys_log"
#

/*!40000 ALTER TABLE `ddsc_sys_log` DISABLE KEYS */;
INSERT INTO `ddsc_sys_log` VALUES (1,'后台登录','2018-12-22 09:13:43','admin','0.0.0.0'),(2,'后台登录','2018-12-24 08:56:23','admin','0.0.0.0'),(3,'后台登录','2018-12-25 10:14:19','admin','0.0.0.0'),(4,'后台登录','2018-12-26 09:34:44','admin','0.0.0.0'),(5,'后台登录','2018-12-27 08:52:04','admin','0.0.0.0'),(6,'后台登录','2018-12-28 08:45:16','admin','0.0.0.0'),(7,'后台登录','2018-12-28 14:22:55','admin','0.0.0.0'),(8,'后台登录','2018-12-28 16:32:44','admin','192.168.101.21'),(9,'后台登录','2018-12-28 19:10:19','admin','1.192.38.201'),(10,'后台登录','2018-12-28 19:49:42','admin','1.192.38.201'),(11,'后台登录','2018-12-29 09:22:51','admin','1.192.38.201'),(12,'后台登录','2018-12-29 16:40:56','admin','1.192.38.201'),(13,'后台登录','2019-01-02 18:08:25','admin','123.161.219.133'),(14,'后台登录','2019-01-03 10:12:59','admin','123.161.219.133'),(15,'后台登录','2019-01-03 13:44:12','admin','123.161.219.133'),(16,'后台登录','2019-01-03 13:45:38','admin','123.161.219.133'),(17,'后台登录','2019-01-03 15:03:05','admin','123.161.219.133'),(18,'后台登录','2019-01-03 16:31:47','admin','123.161.219.133'),(19,'后台登录','2019-01-03 16:34:34','admin','123.161.219.133'),(20,'后台登录','2019-01-03 16:43:33','admin','123.161.219.133'),(21,'后台登录','2019-01-03 17:54:15','admin','123.161.219.133'),(22,'后台登录','2019-01-03 19:21:46','admin','123.161.219.133'),(23,'后台登录','2019-01-03 19:31:49','admin','123.161.219.133'),(24,'后台登录','2019-01-04 09:05:50','admin','123.161.219.211'),(25,'后台登录','2019-01-04 10:39:14','admin','123.161.219.211'),(26,'后台登录','2019-01-04 11:36:49','admin','123.161.219.211'),(27,'后台登录','2019-01-04 16:26:33','admin','123.161.219.211'),(28,'后台登录','2019-01-04 16:40:28','admin','123.161.219.211'),(29,'后台登录','2019-01-04 18:14:45','admin','123.161.219.211'),(30,'后台登录','2019-01-05 15:42:25','admin','123.161.219.211'),(31,'后台登录','2019-01-05 17:38:27','admin','123.161.219.211'),(32,'后台登录','2019-01-06 16:10:51','admin','125.46.76.18'),(33,'后台登录','2019-01-07 14:21:16','admin','123.161.219.217'),(34,'后台登录','2019-01-07 16:33:02','admin','123.161.219.217'),(35,'后台登录','2019-01-07 16:33:52','admin','123.161.219.217'),(36,'后台登录','2019-01-08 10:40:12','admin','123.161.219.217'),(37,'后台登录','2019-01-08 14:10:22','admin','115.60.50.253'),(38,'后台登录','2019-01-09 09:13:04','admin','0.0.0.0'),(39,'后台登录','2019-02-26 09:28:33','admin','127.0.0.1'),(40,'后台登录','2019-02-26 09:36:16','admin','127.0.0.1'),(41,'后台登录','2019-02-26 09:36:35','admin','127.0.0.1'),(42,'后台登录','2019-02-27 08:56:24','admin','127.0.0.1'),(43,'后台登录','2019-02-27 10:01:42','zhangsan','127.0.0.1'),(44,'后台登录','2019-02-27 10:09:10','zhangsan','127.0.0.1'),(45,'后台登录','2019-02-28 09:04:00','admin','192.168.101.181'),(46,'后台登录','2019-02-28 10:13:41','admin','0.0.0.0'),(47,'后台登录','2019-03-01 10:57:26','admin','0.0.0.0'),(48,'后台登录','2019-03-04 09:26:57','admin','0.0.0.0'),(49,'后台登录','2019-03-04 09:42:51','zhangsan','0.0.0.0'),(50,'后台登录','2019-03-04 17:48:36','zhangsan','0.0.0.0'),(51,'后台登录','2019-03-05 11:59:48','admin','0.0.0.0'),(52,'后台登录','2019-03-05 13:56:00','zhangsan','0.0.0.0'),(53,'后台登录','2019-03-06 09:15:56','admin','0.0.0.0'),(54,'后台登录','2019-03-07 09:31:12','admin','0.0.0.0'),(55,'后台登录','2019-03-08 08:58:06','admin','0.0.0.0'),(56,'后台登录','2019-03-12 09:39:03','admin','0.0.0.0'),(57,'后台登录','2019-03-12 11:16:58','zhangsan','0.0.0.0'),(58,'后台登录','2019-03-13 08:58:45','admin','0.0.0.0'),(59,'后台登录','2019-03-14 09:15:39','admin','0.0.0.0'),(60,'后台登录','2019-03-15 08:55:10','admin','0.0.0.0');
/*!40000 ALTER TABLE `ddsc_sys_log` ENABLE KEYS */;

#
# Structure for table "ddsc_type"
#

DROP TABLE IF EXISTS `ddsc_type`;
CREATE TABLE `ddsc_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `type_image` varchar(255) DEFAULT NULL COMMENT '分类图标',
  `type_sort` int(11) NOT NULL DEFAULT '50',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类';

#
# Data for table "ddsc_type"
#

/*!40000 ALTER TABLE `ddsc_type` DISABLE KEYS */;
INSERT INTO `ddsc_type` VALUES (1,'干果',NULL,1),(2,'饮品',NULL,2),(3,'生鲜',NULL,3);
/*!40000 ALTER TABLE `ddsc_type` ENABLE KEYS */;

#
# Structure for table "ddsc_user"
#

DROP TABLE IF EXISTS `ddsc_user`;
CREATE TABLE `ddsc_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `time` varchar(255) DEFAULT NULL COMMENT '注册时间',
  `image` text COMMENT '头像',
  `openid` varchar(255) DEFAULT NULL COMMENT '用户的openID',
  `card` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `integ` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `free_num` int(11) NOT NULL DEFAULT '0' COMMENT '免费使用次数',
  `code` varchar(255) DEFAULT NULL COMMENT '快递柜编码',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户列表';

#
# Data for table "ddsc_user"
#

/*!40000 ALTER TABLE `ddsc_user` DISABLE KEYS */;
INSERT INTO `ddsc_user` VALUES (6,'undefined','1546515068','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKfEYmJxXZEosKcVvzGHVYnnUnOHTPJLLxV4lO6FHCtUIK3pCM9xyibTFMibQrFUZamJ7O38KZroMibw/132','oavnG5WISrylGvxgrPvYGxxCkYXY','',0,'15939590207',0,1,'001'),(7,'小丑','1546515072','https://wx.qlogo.cn/mmopen/vi_32/XibbFRzOVauS5ibPGxv4ialrvJbZYyMPweZtY7Gmh1nXQtibVxjjmxtozhtFvm3rHjbRgIAmRa0ULzLGq4NDIHlZ3A/132','oavnG5TQsodsid-DFLD9YPjkDQw0','uploads/5c77418222402.jpg',0,'',0,0,NULL),(8,'蓝色忧恋','1546762542','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTITmSMvjMPVibib22afCkr7PvBZuL8AjmGZ3D0ibl5xSujyo8zTu4XRNNjyiaVlGPNZ45RteABicCXzqicg/132','oavnG5Yv9gWuN0_vxz2U3dpUb19w','uploads/5c2ecdad2f22d.jpg',0,'',0,0,NULL),(9,'张华华','1546565288','https://wx.qlogo.cn/mmopen/vi_32/ryibeEJsmM1XIYwtd9uHzjiat1oEzQVPIckTEODMyxZNUiaTS1DEusuRNzibw1zyAlozZaSmticsW55yVWR1LbXOVtw/132','oavnG5X2e03Uc0ej2GyO26fW942c','',0,'',0,0,NULL),(10,'Dy','1546564075','https://wx.qlogo.cn/mmopen/vi_32/TZbZyhmoicTgzK9fvRSmKiaeUlXF0ChHKTASHicNFiaDS71VwfZiczibbt6vibnKUDc7Nw1IkxT2ZEjicWU739VovoBKOg/132','oavnG5SfpILozlXBPVvEKy_mAXGA','',0,'',0,0,NULL),(11,'二  月  半  ','1546564076','https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEIjr3P73Vz7hPiaoTh8cFEjic2GPsjNIicYHy5X965ofiaMtjPxm56qoJ85qfavjlzEp1QlydiayhEBfaw/132','oavnG5d3urNSy6RXmLZlKRnwj8As','',0,'',0,0,NULL),(12,'小程序开发-李宜润','1546564219','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTI7hsTibhnpQP1zy3f5ibHiaSeLQImewaFWGNTXVd1ohdFggLKUdxmBamk3F7wiaMibOdcL5rNNjXz7ZzQ/132','oavnG5dcq7x2BHZfYF2aXs8vR2yg','',0,'',0,0,NULL),(14,'꧁༺神仙姐姐༻꧂','1546564635','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erDib7UWDQ2rf5QAGaNtKrIFj7s30b0fPm8dtVIKlrx3vA9OXcJ6cTMd8tDJbs3OFaJUgkR8FJBY5w/132','oavnG5SWW3GiP9pJchCe7wQq8vGs','',0,'',0,0,NULL),(15,'二 月 半','1546564688','https://wx.qlogo.cn/mmopen/vi_32/w1ZLcpJat76Ce4WTEREibRpic4tANgASQmPPXDUeQ3gW4qLd8G4aArZOPzaWOIQib1oe3polgSAmcPMUbh1y4AmsA/132','oavnG5X8ZkK3Y_UmnHb9bITRrdZU','',0,'',0,0,NULL),(16,'暗语寒飞','1546566497','https://wx.qlogo.cn/mmopen/vi_32/uRNqembZfqScc8ChWjJSrrT0ry4iaKHiazAdNZ7wWAicdctViaAldDFEvxUR8icC1ia7RSt313SnAiaBvruVrqyvxBUag/132','oavnG5WPAWFwsmfSXWy4OimgJ7Rc','',0,'',0,0,NULL),(17,'Sion_ren','1546592500','https://wx.qlogo.cn/mmopen/vi_32/xSGbqic7K70FX3B7ytAulRdOdaAyv6pVX1IAK8z6B3zBU6KY2FMcv6ePvGIibX3IXicWnTnq9OzF0Hzuz0kR9fic1g/132','oavnG5RyPfhforZ_NWS7QTGZ8FXA','',0,'',0,0,NULL),(18,'ECHO?','1546570825','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erMia4m1Th04W2fzKZlpNviaQr5OIZ2Gcl5KFG1680TBs2ufCartBJefyN7L3NicFDwSPvMPjGtTPwFA/132','oavnG5dNy-r9qL98b7rEE9RUqNLU','',0,'',0,0,NULL),(22,'小幸运?','1546593249','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo5ibyDUBLLUof40Av2jzmjPfunbjodv4ngnv7opYgiayYpAFIDIjtQ7cjQicvTQpZstc3cTsCR8iaZAw/132','oavnG5ahpimi-dPmXp0xOtKRe6w4','uploads/5c2f3f0536d0b.jpg',19,'',0,0,NULL),(23,'朵朵科技客服','1546602293','https://wx.qlogo.cn/mmopen/vi_32/ExNCPyFI9bEdzycydFPt42UvFVVu5jAMicgyUCXibxQtqH58hyzUnSFicGN9xXtQkxhqeMyHpr7CuFhFWv9icOlalw/132','oavnG5RJEZAm_ZJA-NkCcfa5iDOY','',0,'',0,0,NULL),(24,'黄淑华','1546672212','https://wx.qlogo.cn/mmhead/0PficMg2FogXRvHibk2kflUuwwNKfWa3dPW4XyvEhx4I4/132','oavnG5SpemrpmIdJi2c2lfngIHEs','',0,'',0,0,NULL),(25,'江佳原','1546845479','https://wx.qlogo.cn/mmhead/jXwQMoovVc2Wqx5VXHTxZb8rl8P1eia0YFqVvR30Ycw4/132','oavnG5bd_jcN4kHKiIpJDs4HV2Fc','',0,'',0,0,NULL),(27,'展翅飞翔','1546673228','https://wx.qlogo.cn/mmopen/vi_32/Mtax4H84p1tmwicRuCB3TMkL9ic0V8jcsTtKxISwuvm1F8icaEATuhYa7G7RUBDpPzZCGXx5EOJVa2OdJ0OXLP18A/132','oavnG5XXoVpJhBPzcwtkIsygDQ4Q','',0,'',0,0,NULL),(29,'润物无声','1546699220','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKXOhEO7Z5bqTxWVKU9pvXSLoc0uDseu8em6bAX03EMyR0BAWAdJjy32h1B8E7tGajtVibcym406Ig/132','oavnG5V1Xz7PInWmEWo63Gk0Yrdg','uploads/5c30c1de8e248.jpg',0,'',0,0,NULL),(30,'王嘉德','1546762591','https://wx.qlogo.cn/mmhead/5sEgeNoIv33ocSiaXVR453UF0QrAmr2AsR8zjLkT1GXg/132','oavnG5TmTIcgxY_ccTdQx4DAqA4Y','',0,'',0,0,NULL),(31,'吴侑秋','1546837164','https://wx.qlogo.cn/mmhead/2Y1MpTicN5NHicJIjfyXrfy7xJCOvSVCMQNNCQ3kJovxo/132','oavnG5ejEcS2dva5tFYOd_t7ScDM','',0,'',0,0,NULL),(32,'工程孙欣磊15939033083','1546836101','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJqpARH71Tth8ZJqACBBjNt3vJ6omDJ9MDZFFmhqbl8p8DdIlWqy0NEe7Mtje8uQgibqFEgKZcXVLg/132','oavnG5TGQ4WrdW2l3HKIbHWoJclo','',0,'',0,0,NULL),(33,'? ʚ AN. ɞ','1546928843','https://wx.qlogo.cn/mmopen/vi_32/cqjto0CNcUVxgUM4yaT3tlEMeSGticiaZeDA2BxZBriaxibckibKcZ2gzpyL6odOpVOGeeDmcS7w6zy3zia5k0zsfEfA/132','oavnG5WXXsMACMLW2chYsT6yEcoA','uploads/5c34441923d62.jpg',0,'',0,0,NULL),(34,'黄儒纯','1546924252','https://wx.qlogo.cn/mmhead/y8JI2LH9X0EfpicxbMGWiczD1HB19LNS4OG1WFejTrxibY/132','oavnG5XD-G6DuupnRRvqn6pl7owA','',0,'',0,0,NULL),(35,'林杰廷','1546926710','https://wx.qlogo.cn/mmhead/5tCU4Bs3tY11Hn7G6YlfGnj0yOuxtNjpqungWFJSabA/132','oavnG5bqxJEttxbMzwTTfMFAGGY8','',0,'',0,0,NULL),(36,'LY','1546927263','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erspeMzxBQUicdZcqicInP8lmFPiauG5kOsY4fbry5CzTibyc7Sl5TVdQMBeD1uMAKjSw8QsNp635n7aA/132','oavnG5S2AFYRCvD-3VUMGXbJLxs8','uploads/5c344426cafd5.jpg',0,'',0,0,NULL),(40,'undefined','1551929665','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIEr2pMqS8rlvoQJ5lTLvqQHkMkfyic3e7sG389z3Y2jLLRc826OwbeyGS996PwpAEsqYN7dSziabKA/132','oplp45O53yD8wllMav30LpsuEDps','',0,'',0,0,NULL),(41,'六月','1551947570','https://wx.qlogo.cn/mmopen/vi_32/7mGJJrVib4tC9VFyEf1MyR3Ige05eEdtjSomRnZmGOLQuD81qhiawIic3M6whia6byGlKJDQDRCZntDjnkJnk4RNXQ/132','oplp45G7LJ2TaVhcL9ERwiT33o50','',0,'',0,0,NULL);
/*!40000 ALTER TABLE `ddsc_user` ENABLE KEYS */;
