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

 Date: 09/01/2020 15:17:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
-- Records of fym_valid_table
-- ----------------------------
INSERT INTO `fym_valid_table` VALUES (1, 'source', 1);
INSERT INTO `fym_valid_table` VALUES (2, 'user_detail', 1);
INSERT INTO `fym_valid_table` VALUES (3, 'user', 1);

SET FOREIGN_KEY_CHECKS = 1;
