/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:19:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(64) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` char(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '用户密码',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uname` (`uname`),
  KEY `email` (`email`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('2', 'qqqqqqq', 'q8197264@126.com', '17360492743', '123321a', '2018-12-06 09:49:32', '2018-12-06 13:41:22');
