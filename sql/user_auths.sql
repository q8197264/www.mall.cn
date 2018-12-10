/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:21:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user_auths`
-- ----------------------------
DROP TABLE IF EXISTS `user_auths`;
CREATE TABLE `user_auths` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `grant_type` varchar(255) DEFAULT '' COMMENT '授权登录类型：用户名、手机、邮箱、微博或其它三方应用名称',
  `identifier` varchar(255) DEFAULT NULL COMMENT '用户标识（手机号 邮箱 用户名或第三方应用的唯一标识）',
  `credential` varchar(255) DEFAULT NULL COMMENT ' 密码凭证（站内帐号的密码，三方登陆的access_token）',
  `created_at` datetime DEFAULT NULL,
  `unbind` tinyint(1) DEFAULT 0 COMMENT '是否绑定此帐号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `merge_type_identifier` (`grant_type`,`identifier`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='用户授权';

-- ----------------------------
-- Records of user_auths
-- ----------------------------
INSERT INTO `user_auths` VALUES ('1', '2', 'www', 'qqqqqqq', '18e01727ed929f743ad1ad46d16cc5b0', null, '1');
INSERT INTO `user_auths` VALUES ('2', '30', 'www', 'qqqqqqq1', '42b4e57d16f9be00ed158404bd08389a', null, '0');
INSERT INTO `user_auths` VALUES ('3', '31', 'www', 'qqqqqqq11', '94de1a135fda1a7e184c80b7e3e9836e', null, '0');
INSERT INTO `user_auths` VALUES ('4', '32', 'www', 'qqqqqqq113', 'cb5811771e38c86d888a5c5ec28ee023', null, '0');
INSERT INTO `user_auths` VALUES ('6', '41', '', 'qqqqq@123.com', '7ee274858a19e797949fe615798db1da', '2018-12-09 07:22:47', '0');
INSERT INTO `user_auths` VALUES ('7', '42', 'weibo', 'qqqqq@123.com', 'b6759ca7a82e250b1a90df15de86ad72', '2018-12-09 07:24:36', '0');
INSERT INTO `user_auths` VALUES ('8', '43', 'weibo', 'qqqqqqq1@145.com', 'ba821719922b0ea75f229b5aaabc2a87', '2018-12-09 07:45:32', '0');
INSERT INTO `user_auths` VALUES ('9', '44', 'weibo', 'qqqqqqq45@111.com', 'cabfd125db9b84213a5196521f37bd05', '2018-12-09 07:47:41', '0');
INSERT INTO `user_auths` VALUES ('10', '45', 'weibo', 'q8197264', '9eb491fc149c56ff05070bbf4660ce0f', '2018-12-09 08:32:25', '0');
INSERT INTO `user_auths` VALUES ('11', '46', 'username', 'q8197264', '5b47b3280256079585ef43ce7993d437', '2018-12-09 08:32:55', '1');
INSERT INTO `user_auths` VALUES ('19', '46', 'username', 'qqqqqqq', '123321a', '2018-12-10 06:45:55', '1');
INSERT INTO `user_auths` VALUES ('20', '46', 'phone', '17360492743', '123321a', '2018-12-10 06:45:55', '1');
INSERT INTO `user_auths` VALUES ('21', '46', 'email', 'q8197264@126.com', '123321a', '2018-12-10 06:45:55', '1');
