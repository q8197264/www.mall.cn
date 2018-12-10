/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:21:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户名',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT '更新时间',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户类型 0:买家 1:卖家',
  `off` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否关闭帐号 0否 1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '', null, '2018-12-10 08:04:21', '0', '1');
INSERT INTO `users` VALUES ('2', '', '2018-12-07 08:26:24', '2018-12-10 08:06:24', '0', '1');
INSERT INTO `users` VALUES ('3', '', '2018-12-07 08:36:56', '2018-12-10 08:07:08', '0', '1');
INSERT INTO `users` VALUES ('4', '', '2018-12-07 08:37:30', '2018-12-10 08:15:17', '0', '0');
INSERT INTO `users` VALUES ('5', '', '2018-12-07 08:39:13', '2018-12-10 08:15:17', '0', '0');
INSERT INTO `users` VALUES ('6', '', '2018-12-07 08:55:09', '2018-12-10 08:15:17', '0', '0');
INSERT INTO `users` VALUES ('7', '', '2018-12-07 08:55:45', '2018-12-10 08:15:18', '0', '0');
INSERT INTO `users` VALUES ('8', '', '2018-12-07 08:59:14', '2018-12-10 08:15:18', '0', '0');
INSERT INTO `users` VALUES ('9', '', '2018-12-07 09:06:32', '2018-12-10 08:15:19', '0', '0');
INSERT INTO `users` VALUES ('10', '', '2018-12-07 09:07:38', '2018-12-10 08:15:20', '0', '0');
INSERT INTO `users` VALUES ('11', '', '2018-12-07 09:08:40', '2018-12-10 08:15:19', '0', '0');
INSERT INTO `users` VALUES ('12', '', '2018-12-07 09:19:31', '2018-12-10 08:15:21', '0', '0');
INSERT INTO `users` VALUES ('13', '', '2018-12-07 09:20:18', '2018-12-10 08:15:22', '0', '0');
INSERT INTO `users` VALUES ('14', '', '2018-12-07 09:20:43', '2018-12-10 08:15:22', '0', '0');
INSERT INTO `users` VALUES ('15', '', '2018-12-07 09:22:11', '2018-12-10 08:15:24', '0', '0');
INSERT INTO `users` VALUES ('16', '', '2018-12-07 09:22:44', '2018-12-10 08:15:22', '0', '0');
INSERT INTO `users` VALUES ('17', '', '2018-12-07 09:22:53', null, '0', '0');
INSERT INTO `users` VALUES ('18', '', '2018-12-07 09:23:12', null, '0', '0');
INSERT INTO `users` VALUES ('19', '', '2018-12-07 09:23:26', null, '0', '0');
INSERT INTO `users` VALUES ('20', '', '2018-12-07 09:23:58', null, '0', '0');
INSERT INTO `users` VALUES ('21', '', '2018-12-07 09:44:16', null, '0', '0');
INSERT INTO `users` VALUES ('22', '', '2018-12-07 09:46:46', null, '0', '0');
INSERT INTO `users` VALUES ('23', '', '2018-12-07 10:15:03', null, '0', '0');
INSERT INTO `users` VALUES ('24', '', '2018-12-07 10:15:22', null, '0', '0');
INSERT INTO `users` VALUES ('25', '', '2018-12-07 10:15:33', null, '0', '0');
INSERT INTO `users` VALUES ('26', '', '2018-12-07 10:15:36', null, '0', '0');
INSERT INTO `users` VALUES ('27', '', '2018-12-07 10:15:52', null, '0', '0');
INSERT INTO `users` VALUES ('28', '', '2018-12-07 10:16:07', null, '0', '0');
INSERT INTO `users` VALUES ('29', '', '2018-12-07 10:17:16', null, '0', '0');
INSERT INTO `users` VALUES ('30', '', '2018-12-07 10:27:14', null, '0', '0');
INSERT INTO `users` VALUES ('31', '', '2018-12-07 10:28:39', null, '0', '0');
INSERT INTO `users` VALUES ('32', '', '2018-12-07 10:30:42', null, '0', '0');
INSERT INTO `users` VALUES ('33', '', '2018-12-07 13:40:54', null, '0', '0');
INSERT INTO `users` VALUES ('34', '', '2018-12-08 06:12:30', null, '0', '0');
INSERT INTO `users` VALUES ('35', '', '2018-12-08 06:13:51', null, '0', '0');
INSERT INTO `users` VALUES ('36', '', '2018-12-08 06:14:18', null, '0', '0');
INSERT INTO `users` VALUES ('37', '', '2018-12-08 06:15:59', null, '0', '0');
INSERT INTO `users` VALUES ('38', '', '2018-12-08 06:16:31', null, '0', '0');
INSERT INTO `users` VALUES ('39', '', '2018-12-08 06:41:41', null, '0', '0');
INSERT INTO `users` VALUES ('40', '', '2018-12-08 06:43:31', null, '0', '0');
INSERT INTO `users` VALUES ('41', '', '2018-12-09 07:22:46', null, '0', '0');
INSERT INTO `users` VALUES ('42', '', '2018-12-09 07:24:36', null, '0', '0');
INSERT INTO `users` VALUES ('43', '', '2018-12-09 07:45:31', null, '0', '0');
INSERT INTO `users` VALUES ('44', '', '2018-12-09 07:47:41', null, '0', '0');
INSERT INTO `users` VALUES ('45', '', '2018-12-09 08:32:25', null, '0', '0');
INSERT INTO `users` VALUES ('46', '', '2018-12-09 08:32:55', '2018-12-10 08:16:15', '0', '0');
INSERT INTO `users` VALUES ('47', '', '2018-12-09 16:32:35', null, '0', '0');
