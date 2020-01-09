/*
 Navicat Premium Data Transfer

 Source Server         : bd
 Source Server Type    : MySQL
 Source Server Version : 80018
 Source Host           : localhost:3308
 Source Schema         : fym

 Target Server Type    : MySQL
 Target Server Version : 80018
 File Encoding         : 65001

 Date: 23/12/2019 09:45:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fym_source
-- ----------------------------
DROP TABLE IF EXISTS `fym_source`;
CREATE TABLE `fym_source`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mkey` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `create_time` bigint(20) NULL DEFAULT 0,
  `type` int(11) NULL DEFAULT 0 COMMENT ' 1:keywords\r\n\r\n 2:victitle\r\n\r\n 3:template\r\n\r\n 4:title\r\n\r\n 5:img\r\n\r\n 6:pic\r\n\r\n 7:juzi\r\n\r\n 8:duankous\r\n\r\n 9:lanmu\r\n 10:mulu:当前目录\r\n 11:url当前地址\r\n 12:yuming当前域名',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `mkey`(`mkey`(250)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 731 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_user
-- ----------------------------
DROP TABLE IF EXISTS `fym_user`;
CREATE TABLE `fym_user`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `read_keyword` int(11) NULL DEFAULT 0,
  `read_victitle` int(11) NULL DEFAULT 0,
  `read_tpl` int(11) NULL DEFAULT 0,
  `create_time` bigint(20) NULL DEFAULT 0,
  `visiter_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `update_time` bigint(20) NULL DEFAULT 0,
  `var` int(11) NULL DEFAULT 0,
  `mulu_name` int(255) NULL DEFAULT 0,
  `url` int(255) NULL DEFAULT 0,
  `yuming` int(255) NULL DEFAULT 0,
  `bt_keyword` int(255) NULL DEFAULT 0,
  `detail_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ukey`(`visiter_key`(250)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 76 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_user_detail
-- ----------------------------
DROP TABLE IF EXISTS `fym_user_detail`;
CREATE TABLE `fym_user_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
