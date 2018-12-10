/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:19:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_brand`
-- ----------------------------
DROP TABLE IF EXISTS `goods_brand`;
CREATE TABLE `goods_brand` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(50) NOT NULL COMMENT '品牌名称',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of goods_brand
-- ----------------------------
