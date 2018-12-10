/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : testmall

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-12-11 03:20:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `goods_spec`
-- ----------------------------
DROP TABLE IF EXISTS `goods_spec`;
CREATE TABLE `goods_spec` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `spec_no` varchar(50) NOT NULL COMMENT '规格编号',
  `spec_name` varchar(50) NOT NULL COMMENT '规格名称',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规格表';

-- ----------------------------
-- Records of goods_spec
-- ----------------------------
