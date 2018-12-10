/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:20:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_sku_safeguard`
-- ----------------------------
DROP TABLE IF EXISTS `goods_sku_safeguard`;
CREATE TABLE `goods_sku_safeguard` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` bigint(20) NOT NULL COMMENT 'sku_id',
  `safeguard_id` bigint(20) NOT NULL COMMENT 'safeguard_id',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sku增值保障';

-- ----------------------------
-- Records of goods_sku_safeguard
-- ----------------------------
