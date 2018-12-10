/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:19:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_categories`
-- ----------------------------
DROP TABLE IF EXISTS `goods_categories`;
CREATE TABLE `goods_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL COMMENT '分类名称',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of goods_categories
-- ----------------------------
