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

 Date: 09/01/2020 14:52:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fym_add_queue
-- ----------------------------
DROP TABLE IF EXISTS `fym_add_queue`;
CREATE TABLE `fym_add_queue`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_source_1
-- ----------------------------
DROP TABLE IF EXISTS `fym_source_1`;
CREATE TABLE `fym_source_1`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mkey` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `create_time` bigint(20) NULL DEFAULT 0,
  `type` int(11) NULL DEFAULT 0 COMMENT ' 1:keywords\r\n\r\n 2:victitle\r\n\r\n 3:template\r\n\r\n 4:title\r\n\r\n 5:img\r\n\r\n 6:pic\r\n\r\n 7:juzi\r\n\r\n 8:duankous\r\n\r\n 9:lanmu\r\n 10:mulu:当前目录\r\n 11:url当前地址\r\n 12:yuming当前域名',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mkey`(`mkey`(250), `type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_user_1
-- ----------------------------
DROP TABLE IF EXISTS `fym_user_1`;
CREATE TABLE `fym_user_1`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `detail` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_user_detail_1
-- ----------------------------
DROP TABLE IF EXISTS `fym_user_detail_1`;
CREATE TABLE `fym_user_detail_1`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_valid_table
-- ----------------------------
DROP TABLE IF EXISTS `fym_valid_table`;
CREATE TABLE `fym_valid_table`  (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `num` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fym_visiter_table
-- ----------------------------
DROP TABLE IF EXISTS `fym_visiter_table`;
CREATE TABLE `fym_visiter_table`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `key_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `host`(`host`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
