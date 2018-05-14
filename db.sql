/*
Navicat MySQL Data Transfer

Source Server         : 192.168.8.203
Source Server Version : 50548
Source Host           : 192.168.8.203:3306
Source Database       : zt_print

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2018-03-08 11:09:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for p_news
-- ----------------------------
DROP TABLE IF EXISTS `p_news`;
CREATE TABLE `p_news` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT '主键自增',
  `type_id` bigint(20) DEFAULT '0' COMMENT '分类',
  `type_id2` bigint(20) DEFAULT '0' COMMENT '分类2',
  `flag` varchar(100) DEFAULT NULL COMMENT '自定义属性',
  `channel_id` bigint(20) DEFAULT '0' COMMENT '频道',
  `status` int(25) DEFAULT '1' COMMENT '状态',
  `click` int(10) unsigned DEFAULT '0' COMMENT '点击量',
  `money` int(6) DEFAULT '0' COMMENT '需要金额',
  `title` varchar(100) DEFAULT '' COMMENT '标题',
  `short_title` varchar(100) DEFAULT '' COMMENT '简略标题',
  `color` varchar(10) DEFAULT '' COMMENT '标题颜色',
  `writer` varchar(50) DEFAULT '' COMMENT '作者',
  `source` varchar(50) DEFAULT '' COMMENT '来源',
  `lit_pic` varchar(100) DEFAULT '' COMMENT '缩略图',
  `pubdate` date DEFAULT NULL COMMENT '发布日期',
  `member_user` varchar(50) DEFAULT '0' COMMENT '会员ID',
  `keywords` varchar(100) DEFAULT '' COMMENT '关键字',
  `scores` int(8) DEFAULT '0' COMMENT '分数',
  `good_post` int(8) unsigned DEFAULT '0' COMMENT '好评',
  `bad_post` int(8) unsigned DEFAULT '0' COMMENT '差评',
  `vote_id` varchar(25) DEFAULT NULL COMMENT '评论ID',
  `is_not_post` int(1) unsigned DEFAULT '0' COMMENT '是否允许评论',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `file_name` varchar(100) DEFAULT '' COMMENT '文件名',
  `tack_id` int(10) DEFAULT '0' COMMENT '类型（内容、连接）',
  `weight` int(10) DEFAULT '0' COMMENT '权重',
  `lit_pic2` varchar(100) DEFAULT '' COMMENT '缩略图2',
  `content` varchar(20000) DEFAULT NULL COMMENT '内容',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` varchar(50) DEFAULT NULL COMMENT '创建人',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `update_user` varchar(50) DEFAULT NULL COMMENT '修改人',
  `templet_file` varchar(50) DEFAULT NULL COMMENT '模板',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of p_news
-- ----------------------------

-- ----------------------------
-- Table structure for p_sys_group
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_group`;
CREATE TABLE `p_sys_group` (
  `id` bigint(20) NOT NULL COMMENT '主键自增',
  `group_name` varchar(50) DEFAULT NULL COMMENT '用户组名',
  `remarks` varchar(100) DEFAULT NULL COMMENT '备注',
  `group_status` int(11) DEFAULT NULL COMMENT '组状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统组';

-- ----------------------------
-- Records of p_sys_group
-- ----------------------------
INSERT INTO `p_sys_group` VALUES ('150459252447187', 'test', '', '1');

-- ----------------------------
-- Table structure for p_sys_group_menu
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_group_menu`;
CREATE TABLE `p_sys_group_menu` (
  `id` bigint(20) NOT NULL COMMENT '主建自增',
  `group_id` bigint(20) DEFAULT NULL COMMENT '用户组id',
  `menu_id` bigint(20) DEFAULT NULL COMMENT '菜单id',
  `remarks` varchar(25) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统组的菜单';

-- ----------------------------
-- Records of p_sys_group_menu
-- ----------------------------
INSERT INTO `p_sys_group_menu` VALUES ('15047814326048', '150459252447187', '1010981', null);
INSERT INTO `p_sys_group_menu` VALUES ('15047814358026', '150459252447187', '1010775', null);
INSERT INTO `p_sys_group_menu` VALUES ('15047814393001', '150459252447187', '1065617', null);
INSERT INTO `p_sys_group_menu` VALUES ('16229461279836', '150459252447187', '15177283370627', null);
INSERT INTO `p_sys_group_menu` VALUES ('150477299494186', '150459252447187', '1022065', null);
INSERT INTO `p_sys_group_menu` VALUES ('150477299545794', '150459252447187', '1022485', null);
INSERT INTO `p_sys_group_menu` VALUES ('150478142959362', '150459252447187', '0', null);
INSERT INTO `p_sys_group_menu` VALUES ('150478142989112', '150459252447187', '1010641', null);
INSERT INTO `p_sys_group_menu` VALUES ('150478143141141', '150459252447187', '1010640', null);
INSERT INTO `p_sys_group_menu` VALUES ('162294523626912', '150459252447187', '15177260968147', null);
INSERT INTO `p_sys_group_menu` VALUES ('162294523697770', '150459252447187', '15183829295892', null);
INSERT INTO `p_sys_group_menu` VALUES ('162294659343335', '150459252447187', '151838252759952', null);

-- ----------------------------
-- Table structure for p_sys_group_user
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_group_user`;
CREATE TABLE `p_sys_group_user` (
  `id` bigint(20) NOT NULL COMMENT '主建自增',
  `group_id` bigint(20) DEFAULT NULL COMMENT '用户组id',
  `user` varchar(50) DEFAULT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统组用户';

-- ----------------------------
-- Records of p_sys_group_user
-- ----------------------------
INSERT INTO `p_sys_group_user` VALUES ('150478118498699', '150459252447187', 'test1');
INSERT INTO `p_sys_group_user` VALUES ('161780849312707', '150459252447187', '10');

-- ----------------------------
-- Table structure for p_sys_log
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_log`;
CREATE TABLE `p_sys_log` (
  `id` bigint(20) NOT NULL COMMENT '表主键',
  `data_time` datetime DEFAULT NULL COMMENT '时间',
  `user` varchar(32) DEFAULT NULL COMMENT '用户',
  `log_type` int(11) DEFAULT NULL COMMENT '操作类型',
  `content` varchar(500) DEFAULT NULL COMMENT '操作内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统操作日志';

-- ----------------------------
-- Records of p_sys_log
-- ----------------------------
INSERT INTO `p_sys_log` VALUES ('16067967768573', '2018-01-23 09:14:37', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('16068019455585', '2018-01-23 09:23:14', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('16068025150205', '2018-01-23 09:24:11', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160671591953300', '2018-01-23 06:59:51', 'admin', '4', '修改密码test');
INSERT INTO `p_sys_log` VALUES ('160671842844022', '2018-01-23 07:04:02', 'admin', '3', '添加用户test');
INSERT INTO `p_sys_log` VALUES ('160672470108119', '2018-01-23 07:14:30', 'admin', '3', '添加用户test1');
INSERT INTO `p_sys_log` VALUES ('160678844537224', '2018-01-23 09:00:44', 'admin', '3', '菜单ttt信息');
INSERT INTO `p_sys_log` VALUES ('160678865293824', '2018-01-23 09:01:05', 'admin', '3', '菜单ttt22信息');
INSERT INTO `p_sys_log` VALUES ('160678892235552', '2018-01-23 09:01:32', 'admin', '3', '菜单ttt2211信息');
INSERT INTO `p_sys_log` VALUES ('160679218288807', '2018-01-23 09:06:58', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160679218452030', '2018-01-23 09:06:58', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160679514805346', '2018-01-23 09:11:54', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160679693191365', '2018-01-23 09:14:53', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160680166884817', '2018-01-23 09:22:46', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160680225153386', '2018-01-23 09:23:45', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160680345496736', '2018-01-23 09:25:45', 'admin', '5', '菜单信息');
INSERT INTO `p_sys_log` VALUES ('160680345641102', '2018-01-23 09:25:45', 'admin', '5', '菜单信息');

-- ----------------------------
-- Table structure for p_sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_menu`;
CREATE TABLE `p_sys_menu` (
  `id` bigint(20) NOT NULL COMMENT '自增',
  `pid` bigint(20) DEFAULT NULL COMMENT '父菜单ID',
  `menu_name` varchar(100) DEFAULT NULL COMMENT '菜单名',
  `menu_type` varchar(100) DEFAULT NULL COMMENT '类型',
  `menu_site` varchar(100) DEFAULT NULL COMMENT '菜单位置',
  `menu_path` varchar(200) DEFAULT NULL COMMENT '菜单地址',
  `target` varchar(50) DEFAULT NULL COMMENT '打开框架名',
  `remarks` varchar(200) DEFAULT NULL COMMENT '备注',
  `menu_status` int(11) DEFAULT '0' COMMENT '状态',
  `order_id` int(11) DEFAULT NULL COMMENT '排序',
  `group` varchar(10) DEFAULT NULL COMMENT '分组',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统菜单';

-- ----------------------------
-- Records of p_sys_menu
-- ----------------------------
INSERT INTO `p_sys_menu` VALUES ('1010640', '1010641', '用户管理', null, null, 'admin/sysUser/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1010641', '0', '系统管理', '00000', '1', '#', '', '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1010775', '1010641', '系统菜单', null, null, 'admin/sysMenu/adminTree', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1010981', '1010641', '组管理', null, null, 'admin/sysGroup/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1014946', '0', '会员管理', null, null, '#', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1015176', '1014946', '会员管理', null, null, 'admin/user/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1022065', '0', '信息管理', null, null, '#', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1022256', '1022065', '文章分类', null, null, 'admin/newsType/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1022485', '1022065', '文章管理', null, null, 'admin/news/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('1065617', '1010641', '日志管理', null, null, 'admin/sysLog/index', null, '', '1', '0', null);
INSERT INTO `p_sys_menu` VALUES ('15177260968147', '0', '其他管理', null, null, '', null, '', '1', null, null);
INSERT INTO `p_sys_menu` VALUES ('15177283370627', '15177260968147', '微信支付订单', null, null, 'admin/wxpayOrder/index', null, '', '1', null, null);
INSERT INTO `p_sys_menu` VALUES ('15183829295892', '15177260968147', '微信公众号', null, null, 'admin/sysWeixin/index', null, '', '1', null, null);
INSERT INTO `p_sys_menu` VALUES ('151838252759952', '15177260968147', '微信用户', null, null, 'admin/wxUser/index', null, '', '1', null, null);

-- ----------------------------
-- Table structure for p_sys_user
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_user`;
CREATE TABLE `p_sys_user` (
  `id` bigint(20) NOT NULL COMMENT '主键自增',
  `user` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` varchar(50) DEFAULT NULL COMMENT '用户密码',
  `user_type` int(11) DEFAULT NULL COMMENT '用户类型',
  `mail` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机',
  `create_date` datetime DEFAULT NULL COMMENT '注册时间',
  `level` int(11) DEFAULT NULL COMMENT '用户级别',
  `remarks` varchar(100) DEFAULT NULL COMMENT '备注',
  `user_status` int(11) DEFAULT NULL COMMENT '用户状态',
  `error_date` datetime DEFAULT NULL COMMENT '登录错误时间',
  `error_no` int(11) DEFAULT NULL COMMENT '登录错误次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统用户';

-- ----------------------------
-- Records of p_sys_user
-- ----------------------------
INSERT INTO `p_sys_user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', null, null, null, null, '99', null, '1', null, null);
INSERT INTO `p_sys_user` VALUES ('2', '2', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('3', '3', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('4', '4', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('5', '5', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('6', '6', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('7', '7', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('8', '8', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('9', '9', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('10', '10', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `p_sys_user` VALUES ('16067247055541', 'test1', '96e79218965eb72c92a549dd5a330112', null, '', '', '2018-01-23 07:14:30', '10', '', '1', null, null);
INSERT INTO `p_sys_user` VALUES ('160671842790919', 'test', '96e79218965eb72c92a549dd5a330112', null, '', '', '2018-01-23 07:04:02', '10', '', '1', null, null);

-- ----------------------------
-- Table structure for p_sys_weixin
-- ----------------------------
DROP TABLE IF EXISTS `p_sys_weixin`;
CREATE TABLE `p_sys_weixin` (
  `id` bigint(20) NOT NULL COMMENT '主键自增',
  `title` varchar(50) DEFAULT '' COMMENT '名称',
  `wechat_user` varchar(50) DEFAULT NULL COMMENT '微信帐号',
  `token` varchar(64) DEFAULT NULL COMMENT 'token',
  `encoding_aes_key` varchar(64) DEFAULT NULL COMMENT 'EncodingAESKey',
  `appid` varchar(64) DEFAULT NULL COMMENT 'appid',
  `appsecret` varchar(64) DEFAULT NULL COMMENT 'appsecret',
  `mchid` varchar(64) DEFAULT '' COMMENT '支付mchid',
  `key` varchar(64) DEFAULT NULL COMMENT '支付用KEY',
  `ip` varchar(64) DEFAULT NULL COMMENT 'IP',
  `domainname` varchar(64) DEFAULT '' COMMENT '域名',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `wechat_status` int(11) DEFAULT NULL COMMENT '状态',
  `create_user` varchar(50) DEFAULT NULL COMMENT '用户',
  `web_url` varchar(50) DEFAULT NULL COMMENT '地址',
  PRIMARY KEY (`id`),
  KEY `reid` (`key`,`ip`),
  KEY `sortrank` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信服务号';

-- ----------------------------
-- Records of p_sys_weixin
-- ----------------------------
INSERT INTO `p_sys_weixin` VALUES ('151839816470096', '1', '1', '1', '1', '1', '1', '1', '1', '', '11', '2017-10-13 09:43:36', '2', null, '1');
INSERT INTO `p_sys_weixin` VALUES ('151839915185015', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2017-10-13 09:45:15', '1', 'admin', '2');
