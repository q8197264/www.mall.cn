/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:20:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_spu`
-- ----------------------------
DROP TABLE IF EXISTS `goods_spu`;
CREATE TABLE `goods_spu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `spu_no` varchar(50) NOT NULL COMMENT '商品编号，唯一',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名称',
  `low_price` decimal(9,2) NOT NULL COMMENT '最低售价',
  `category_id` bigint(20) NOT NULL COMMENT '分类id',
  `brand_id` bigint(20) NOT NULL COMMENT '品牌id',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_spu_no` (`spu_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='spu表';

-- ----------------------------
-- Records of goods_spu
-- ----------------------------
