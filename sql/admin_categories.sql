/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:19:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_categories`
-- ----------------------------
DROP TABLE IF EXISTS `admin_categories`;
CREATE TABLE `admin_categories` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cid` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '子类id',
  `pid` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '父类id',
  `cname` varchar(20) NOT NULL DEFAULT '' COMMENT '类名',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cid` (`cid`) USING BTREE,
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='后台导航菜单分类表';

-- ----------------------------
-- Records of admin_categories
-- ----------------------------
INSERT INTO `admin_categories` VALUES ('1', '1', '0', '会员管理', '0');
INSERT INTO `admin_categories` VALUES ('2', '2', '0', '商品管理', '0');
INSERT INTO `admin_categories` VALUES ('3', '3', '0', '订单管理', '0');
INSERT INTO `admin_categories` VALUES ('4', '4', '0', '系统设置', '0');
INSERT INTO `admin_categories` VALUES ('5', '5', '1', '会员列表', '0');
INSERT INTO `admin_categories` VALUES ('6', '6', '2', '商品列表', '0');
INSERT INTO `admin_categories` VALUES ('7', '7', '2', '商品库存', '0');
INSERT INTO `admin_categories` VALUES ('8', '8', '6', '商品属性', '0');
INSERT INTO `admin_categories` VALUES ('9', '9', '0', '销售报表', '0');
