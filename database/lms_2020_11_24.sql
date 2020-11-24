/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost:3306
 Source Schema         : lms

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 24/11/2020 15:00:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for folder
-- ----------------------------
DROP TABLE IF EXISTS `folder`;
CREATE TABLE `folder` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` int(10) unsigned DEFAULT NULL,
  `resource` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of folder
-- ----------------------------
BEGIN;
INSERT INTO `folder` VALUES (1, NULL, NULL, 'root', NULL, NULL);
INSERT INTO `folder` VALUES (2, NULL, NULL, 'resource', 1, 1);
INSERT INTO `folder` VALUES (3, NULL, NULL, 'documents', 1, NULL);
INSERT INTO `folder` VALUES (4, NULL, NULL, 'graphics', 1, NULL);
INSERT INTO `folder` VALUES (5, NULL, NULL, 'other', 1, NULL);
COMMIT;

-- ----------------------------
-- Table structure for lms_branches
-- ----------------------------
DROP TABLE IF EXISTS `lms_branches`;
CREATE TABLE `lms_branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lms_branches
-- ----------------------------
BEGIN;
INSERT INTO `lms_branches` VALUES (1, 'Trung tâm láng hạ', '<p>ghi chú trung tâm</p>', 1, '2020-11-06 17:45:21', 1, '2020-11-23 17:07:20', 1);
COMMIT;

-- ----------------------------
-- Table structure for lms_classes
-- ----------------------------
DROP TABLE IF EXISTS `lms_classes`;
CREATE TABLE `lms_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lms_classes
-- ----------------------------
BEGIN;
INSERT INTO `lms_classes` VALUES (1, 1, 2, 'Lớp 1A', '<p>Ghi chú lớp học</p>', '2020-11-07 11:03:34', 1, '2020-11-23 17:09:00', 1, 1);
INSERT INTO `lms_classes` VALUES (2, 2, 6, 'Lớp CDI 1', NULL, '2020-11-07 11:23:00', 16, NULL, NULL, 1);
COMMIT;

-- ----------------------------
-- Table structure for lms_products
-- ----------------------------
DROP TABLE IF EXISTS `lms_products`;
CREATE TABLE `lms_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  `lang` tinyint(2) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lms_products
-- ----------------------------
BEGIN;
INSERT INTO `lms_products` VALUES (1, 1, 'Sản phẩm 1', 1, NULL, NULL, '2020-09-17 00:01:58', 1, 0, NULL);
INSERT INTO `lms_products` VALUES (2, 1, 'Sản phẩm 2', 1, '2020-09-14 07:07:07', 0, NULL, NULL, 0, NULL);
INSERT INTO `lms_products` VALUES (3, 1, 'Sản phẩm 3', 1, '2020-09-14 07:08:38', 1, NULL, NULL, 0, NULL);
INSERT INTO `lms_products` VALUES (6, 2, 'CDI', 1, '2020-11-07 11:21:59', 16, NULL, NULL, 0, NULL);
COMMIT;

-- ----------------------------
-- Table structure for lms_quiz
-- ----------------------------
DROP TABLE IF EXISTS `lms_quiz`;
CREATE TABLE `lms_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_cauhoi` char(50) CHARACTER SET utf8 DEFAULT NULL,
  `noidung_quiz` mediumtext CHARACTER SET utf8 NOT NULL,
  `dokho_quiz` int(11) NOT NULL DEFAULT '3',
  `dapan_quiz` mediumtext CHARACTER SET utf8 NOT NULL,
  `goiy` mediumtext CHARACTER SET utf8,
  `giaithich_quiz` mediumtext CHARACTER SET utf8,
  `meta_data` mediumtext COLLATE utf8_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  `lang` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lms_quiz
-- ----------------------------
BEGIN;
INSERT INTO `lms_quiz` VALUES (4, '100005', '{\"intro\":\"\\u003Cp\\u003E5 - 2 = ?\\u003C\\/p\\u003E\",\"template\":\"large\",\"is_multichoice\":\"1\",\"option_html\":\"\\u003Cp\\u003E1) l\\u1ef1a ch\\u1ecdn 1\\u003C\\/p\\u003E\\n\\u003Cp\\u003E2) l\\u1ef1a ch\\u1ecdn 2\\u003C\\/p\\u003E\\n\\u003Cp\\u003E3) l\\u1ef1a ch\\u1ecdn 3\\u003C\\/p\\u003E\",\"option\":{\"1\":\"l\\u1ef1a ch\\u1ecdn 1\",\"2\":\"l\\u1ef1a ch\\u1ecdn 2\",\"3\":\"l\\u1ef1a ch\\u1ecdn 3\"}}', 2, '3', NULL, '<p>giải thích 1</p>', NULL, 1, 1, '2020-09-17 00:55:55', 1, '2020-09-23 10:50:52', 1, 0);
INSERT INTO `lms_quiz` VALUES (6, '100006', '{\"intro\":\"\\u003Cp\\u003E1 + 2 = \\/*1*\\/\\u003C\\/p\\u003E\",\"template\":\"default\",\"type_convert\":1}', 2, '{\"1\":\"3\"}', NULL, '<p>Giải thích quiz</p>', '<p>1)3</p>', 1, 2, '2020-09-17 23:03:21', 1, NULL, NULL, 0);
INSERT INTO `lms_quiz` VALUES (8, '100007', '{\"intro\":\"\\u003Cp\\u003E1+3 = ?\\u003C\\/p\\u003E\"}', 2, '', NULL, '<p>Giải thích tự luận </p>', NULL, 1, 3, '2020-09-17 23:12:01', 1, NULL, NULL, 0);
COMMIT;

-- ----------------------------
-- Table structure for lms_students
-- ----------------------------
DROP TABLE IF EXISTS `lms_students`;
CREATE TABLE `lms_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gud_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gud_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gud_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lms_students
-- ----------------------------
BEGIN;
INSERT INTO `lms_students` VALUES (2, 1, 'Học sinh 1', '2020-11-23', '0389941902', NULL, NULL, NULL, NULL, '2020-11-23 17:30:55', 1, NULL, NULL, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for lms_tuition_fees
-- ----------------------------
DROP TABLE IF EXISTS `lms_tuition_fees`;
CREATE TABLE `lms_tuition_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `receivable` int(11) DEFAULT NULL,
  `session` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updator_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for media
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of media
-- ----------------------------
BEGIN;
INSERT INTO `media` VALUES (2, 'App\\Models\\Folder', 2, 'default', 'FullSizeRender 2.jpg', '20200827050953FullSizeRender-2.jpg', 'image/jpeg', 'public', 1604293, '[]', '[]', '[]', 1, '2020-08-27 05:09:53', '2020-08-27 05:09:53');
COMMIT;

-- ----------------------------
-- Table structure for menu_role
-- ----------------------------
DROP TABLE IF EXISTS `menu_role`;
CREATE TABLE `menu_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menus_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=267 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menu_role
-- ----------------------------
BEGIN;
INSERT INTO `menu_role` VALUES (5, 'guest', 3);
INSERT INTO `menu_role` VALUES (18, 'user', 13);
INSERT INTO `menu_role` VALUES (19, 'admin', 13);
INSERT INTO `menu_role` VALUES (20, 'user', 14);
INSERT INTO `menu_role` VALUES (21, 'admin', 14);
INSERT INTO `menu_role` VALUES (22, 'user', 15);
INSERT INTO `menu_role` VALUES (23, 'admin', 15);
INSERT INTO `menu_role` VALUES (24, 'user', 16);
INSERT INTO `menu_role` VALUES (25, 'admin', 16);
INSERT INTO `menu_role` VALUES (26, 'user', 17);
INSERT INTO `menu_role` VALUES (27, 'admin', 17);
INSERT INTO `menu_role` VALUES (28, 'user', 18);
INSERT INTO `menu_role` VALUES (29, 'admin', 18);
INSERT INTO `menu_role` VALUES (30, 'user', 19);
INSERT INTO `menu_role` VALUES (31, 'admin', 19);
INSERT INTO `menu_role` VALUES (32, 'user', 20);
INSERT INTO `menu_role` VALUES (33, 'admin', 20);
INSERT INTO `menu_role` VALUES (34, 'user', 21);
INSERT INTO `menu_role` VALUES (35, 'admin', 21);
INSERT INTO `menu_role` VALUES (36, 'user', 22);
INSERT INTO `menu_role` VALUES (37, 'admin', 22);
INSERT INTO `menu_role` VALUES (38, 'user', 23);
INSERT INTO `menu_role` VALUES (39, 'admin', 23);
INSERT INTO `menu_role` VALUES (40, 'user', 24);
INSERT INTO `menu_role` VALUES (41, 'admin', 24);
INSERT INTO `menu_role` VALUES (42, 'user', 25);
INSERT INTO `menu_role` VALUES (43, 'admin', 25);
INSERT INTO `menu_role` VALUES (44, 'user', 26);
INSERT INTO `menu_role` VALUES (45, 'admin', 26);
INSERT INTO `menu_role` VALUES (46, 'user', 27);
INSERT INTO `menu_role` VALUES (47, 'admin', 27);
INSERT INTO `menu_role` VALUES (48, 'user', 28);
INSERT INTO `menu_role` VALUES (49, 'admin', 28);
INSERT INTO `menu_role` VALUES (50, 'user', 29);
INSERT INTO `menu_role` VALUES (51, 'admin', 29);
INSERT INTO `menu_role` VALUES (52, 'user', 30);
INSERT INTO `menu_role` VALUES (53, 'admin', 30);
INSERT INTO `menu_role` VALUES (54, 'user', 31);
INSERT INTO `menu_role` VALUES (55, 'admin', 31);
INSERT INTO `menu_role` VALUES (56, 'user', 32);
INSERT INTO `menu_role` VALUES (57, 'admin', 32);
INSERT INTO `menu_role` VALUES (58, 'user', 33);
INSERT INTO `menu_role` VALUES (59, 'admin', 33);
INSERT INTO `menu_role` VALUES (60, 'user', 34);
INSERT INTO `menu_role` VALUES (61, 'admin', 34);
INSERT INTO `menu_role` VALUES (62, 'user', 35);
INSERT INTO `menu_role` VALUES (63, 'admin', 35);
INSERT INTO `menu_role` VALUES (64, 'user', 36);
INSERT INTO `menu_role` VALUES (65, 'admin', 36);
INSERT INTO `menu_role` VALUES (66, 'user', 37);
INSERT INTO `menu_role` VALUES (67, 'admin', 37);
INSERT INTO `menu_role` VALUES (68, 'user', 38);
INSERT INTO `menu_role` VALUES (69, 'admin', 38);
INSERT INTO `menu_role` VALUES (70, 'user', 39);
INSERT INTO `menu_role` VALUES (71, 'admin', 39);
INSERT INTO `menu_role` VALUES (72, 'user', 40);
INSERT INTO `menu_role` VALUES (73, 'admin', 40);
INSERT INTO `menu_role` VALUES (74, 'user', 41);
INSERT INTO `menu_role` VALUES (75, 'admin', 41);
INSERT INTO `menu_role` VALUES (76, 'user', 42);
INSERT INTO `menu_role` VALUES (77, 'admin', 42);
INSERT INTO `menu_role` VALUES (78, 'user', 43);
INSERT INTO `menu_role` VALUES (79, 'admin', 43);
INSERT INTO `menu_role` VALUES (80, 'user', 44);
INSERT INTO `menu_role` VALUES (81, 'admin', 44);
INSERT INTO `menu_role` VALUES (82, 'user', 45);
INSERT INTO `menu_role` VALUES (83, 'admin', 45);
INSERT INTO `menu_role` VALUES (84, 'user', 46);
INSERT INTO `menu_role` VALUES (85, 'admin', 46);
INSERT INTO `menu_role` VALUES (86, 'user', 47);
INSERT INTO `menu_role` VALUES (87, 'admin', 47);
INSERT INTO `menu_role` VALUES (88, 'user', 48);
INSERT INTO `menu_role` VALUES (89, 'admin', 48);
INSERT INTO `menu_role` VALUES (90, 'user', 49);
INSERT INTO `menu_role` VALUES (91, 'admin', 49);
INSERT INTO `menu_role` VALUES (92, 'user', 50);
INSERT INTO `menu_role` VALUES (93, 'admin', 50);
INSERT INTO `menu_role` VALUES (94, 'guest', 51);
INSERT INTO `menu_role` VALUES (95, 'user', 51);
INSERT INTO `menu_role` VALUES (96, 'admin', 51);
INSERT INTO `menu_role` VALUES (117, 'guest', 2);
INSERT INTO `menu_role` VALUES (128, 'admin', 65);
INSERT INTO `menu_role` VALUES (129, 'user', 65);
INSERT INTO `menu_role` VALUES (130, 'guest', 65);
INSERT INTO `menu_role` VALUES (188, 'admin', 1);
INSERT INTO `menu_role` VALUES (189, 'Giáo viên', 1);
INSERT INTO `menu_role` VALUES (190, 'supper admin', 1);
INSERT INTO `menu_role` VALUES (191, 'admin', 66);
INSERT INTO `menu_role` VALUES (192, 'supper admin', 66);
INSERT INTO `menu_role` VALUES (193, 'Giáo viên', 66);
INSERT INTO `menu_role` VALUES (194, 'admin', 67);
INSERT INTO `menu_role` VALUES (195, 'supper admin', 67);
INSERT INTO `menu_role` VALUES (196, 'Giáo viên', 67);
INSERT INTO `menu_role` VALUES (199, 'admin', 69);
INSERT INTO `menu_role` VALUES (200, 'Giáo viên', 69);
INSERT INTO `menu_role` VALUES (201, 'supper admin', 69);
INSERT INTO `menu_role` VALUES (202, 'admin', 64);
INSERT INTO `menu_role` VALUES (203, 'Giáo viên', 64);
INSERT INTO `menu_role` VALUES (204, 'supper admin', 64);
INSERT INTO `menu_role` VALUES (205, 'supper admin', 4);
INSERT INTO `menu_role` VALUES (208, 'supper admin', 63);
INSERT INTO `menu_role` VALUES (209, 'supper admin', 68);
INSERT INTO `menu_role` VALUES (210, 'admin', 71);
INSERT INTO `menu_role` VALUES (211, 'giáo viên', 71);
INSERT INTO `menu_role` VALUES (212, 'supper admin', 71);
INSERT INTO `menu_role` VALUES (252, 'supper admin', 73);
INSERT INTO `menu_role` VALUES (253, 'admin', 73);
INSERT INTO `menu_role` VALUES (254, 'supper admin', 72);
INSERT INTO `menu_role` VALUES (255, 'admin', 72);
INSERT INTO `menu_role` VALUES (256, 'giáo viên', 72);
INSERT INTO `menu_role` VALUES (257, 'supper admin', 6);
INSERT INTO `menu_role` VALUES (258, 'admin', 6);
INSERT INTO `menu_role` VALUES (260, 'supper admin', 7);
INSERT INTO `menu_role` VALUES (261, 'supper admin', 5);
INSERT INTO `menu_role` VALUES (262, 'admin', 5);
INSERT INTO `menu_role` VALUES (263, 'giáo viên', 5);
INSERT INTO `menu_role` VALUES (264, 'học sinh', 5);
INSERT INTO `menu_role` VALUES (265, 'supper admin', 74);
INSERT INTO `menu_role` VALUES (266, 'admin', 74);
COMMIT;

-- ----------------------------
-- Table structure for menulist
-- ----------------------------
DROP TABLE IF EXISTS `menulist`;
CREATE TABLE `menulist` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menulist
-- ----------------------------
BEGIN;
INSERT INTO `menulist` VALUES (1, 'sidebar menu');
INSERT INTO `menulist` VALUES (2, 'top_menu');
COMMIT;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `href` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
BEGIN;
INSERT INTO `menus` VALUES (1, 'Dashboard', '/', 'cil-speedometer', 'link', NULL, 1, 1);
INSERT INTO `menus` VALUES (2, 'Login', '/login', 'cil-account-logout', 'link', NULL, 1, 2);
INSERT INTO `menus` VALUES (3, 'Register', '/register', 'cil-account-logout', 'link', NULL, 1, 3);
INSERT INTO `menus` VALUES (4, 'Settings', '/', 'cil-settings', 'dropdown', NULL, 1, 18);
INSERT INTO `menus` VALUES (5, 'Media', '/media', 'cil-library-add', 'link', NULL, 1, 4);
INSERT INTO `menus` VALUES (6, 'Nhân Viên', '/users', 'cil-user', 'link', 0, 1, 6);
INSERT INTO `menus` VALUES (7, 'Menu', '/menu', NULL, 'link', 4, 1, 10);
INSERT INTO `menus` VALUES (63, 'Role', '/roles', NULL, 'link', 4, 1, 11);
INSERT INTO `menus` VALUES (64, 'Sản phẩm', '/products', NULL, 'link', 69, 1, 13);
INSERT INTO `menus` VALUES (66, 'Nội Dung', NULL, 'cil-file', 'dropdown', 0, 1, 5);
INSERT INTO `menus` VALUES (67, 'Câu hỏi', '/quizs', NULL, 'link', 66, 1, 14);
INSERT INTO `menus` VALUES (68, 'Trung Tâm', '/branches', NULL, 'link', 4, 1, 12);
INSERT INTO `menus` VALUES (69, 'Hệ Thống', NULL, 'cil-layers', 'dropdown', 0, 1, 7);
INSERT INTO `menus` VALUES (71, 'Lớp', '/classes', NULL, 'link', 69, 1, 19);
INSERT INTO `menus` VALUES (72, 'Học Sinh', '/students', 'cil-user-follow', 'link', 0, 1, 16);
INSERT INTO `menus` VALUES (73, 'Vận Hành', NULL, 'cil-tv', 'dropdown', 0, 1, 17);
INSERT INTO `menus` VALUES (74, 'Gói phí', '/tuition_fees', 'cil-dollar', 'link', 69, 1, 20);
COMMIT;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`) USING BTREE,
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
BEGIN;
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 1);
INSERT INTO `model_has_roles` VALUES (2, 'App\\User', 1);
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 2);
INSERT INTO `model_has_roles` VALUES (2, 'App\\User', 2);
INSERT INTO `model_has_roles` VALUES (4, 'App\\User', 15);
INSERT INTO `model_has_roles` VALUES (2, 'App\\User', 16);
COMMIT;

-- ----------------------------
-- Table structure for role_hierarchy
-- ----------------------------
DROP TABLE IF EXISTS `role_hierarchy`;
CREATE TABLE `role_hierarchy` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `hierarchy` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_hierarchy
-- ----------------------------
BEGIN;
INSERT INTO `role_hierarchy` VALUES (1, 1, 2);
INSERT INTO `role_hierarchy` VALUES (2, 2, 3);
INSERT INTO `role_hierarchy` VALUES (3, 3, 5);
INSERT INTO `role_hierarchy` VALUES (4, 4, 4);
INSERT INTO `role_hierarchy` VALUES (5, 5, 1);
INSERT INTO `role_hierarchy` VALUES (6, 6, 6);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES (1, 'supper admin', 'api', '2020-08-27 02:04:43', '2020-08-27 02:04:43');
INSERT INTO `roles` VALUES (2, 'admin', 'api', '2020-08-27 02:04:43', '2020-08-27 02:04:43');
INSERT INTO `roles` VALUES (4, 'giáo viên', 'api', '2020-11-05 15:30:59', '2020-11-06 17:43:15');
INSERT INTO `roles` VALUES (6, 'học sinh', 'api', '2020-11-07 11:37:42', '2020-11-07 11:37:42');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menuroles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  UNIQUE KEY `users_api_token_unique` (`api_token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 1, 'Supper admin', 'supperadmin@gmail.com', '2020-08-27 02:04:43', '$2y$10$Hg7QVCSVFWbMfi.c0/vuNeqgcUO/dho/Iaf2aMj8VQFcwEw02ZLn2', NULL, 'supper admin,user', 'EQt3UDeo4F', '2020-08-27 02:04:43', '2020-09-04 10:58:15', NULL, 1);
INSERT INTO `users` VALUES (2, 1, 'Admin', 'admin@gmail.com', '2020-08-27 02:04:43', '$2y$10$Hg7QVCSVFWbMfi.c0/vuNeqgcUO/dho/Iaf2aMj8VQFcwEw02ZLn2', NULL, 'admin', 'EJnBBZcle2', '2020-08-27 02:04:43', '2020-11-05 17:56:56', NULL, 1);
INSERT INTO `users` VALUES (15, 1, 'Giáo viên', 'giaovien@gmail.com', NULL, '$2y$10$Hg7QVCSVFWbMfi.c0/vuNeqgcUO/dho/Iaf2aMj8VQFcwEw02ZLn2', NULL, 'Giáo viên', NULL, '2020-11-05 17:52:41', '2020-11-05 17:52:41', NULL, 1);
INSERT INTO `users` VALUES (16, 2, 'Admin trung tâm 2', 'admin2@gmail.com', '2020-11-07 11:20:34', '$2y$10$mMZ62ExhUxLEq2dUml8fgOqBhblG3Hf7fkU.J.ayc.k0gN6nygJky', NULL, 'admin', NULL, '2020-11-07 11:20:34', '2020-11-07 11:20:53', NULL, 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
