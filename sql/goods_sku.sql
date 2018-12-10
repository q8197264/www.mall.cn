/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:20:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_sku`
-- ----------------------------
DROP TABLE IF EXISTS `goods_sku`;
CREATE TABLE `goods_sku` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sku_no` varchar(50) NOT NULL COMMENT 'sku编号,唯一',
  `sku_name` varchar(50) NOT NULL COMMENT 'sku名称(冗余spu_name)',
  `price` decimal(9,2) NOT NULL COMMENT '售价',
  `stock` int(11) NOT NULL COMMENT '库存',
  `shop_id` bigint(20) NOT NULL COMMENT '商铺id,为0表示自营',
  `spu_id` bigint(20) NOT NULL COMMENT 'spu_id',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sku表';

-- ----------------------------
-- Records of goods_sku
-- ----------------------------
