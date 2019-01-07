/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : smartinterview_db

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 07/01/2019 12:18:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for conversations
-- ----------------------------
DROP TABLE IF EXISTS `conversations`;
CREATE TABLE `conversations`  (
  `id` int(11) NOT NULL,
  `user_one` int(11) NULL DEFAULT NULL,
  `user_two` int(11) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for interview
-- ----------------------------
DROP TABLE IF EXISTS `interview`;
CREATE TABLE `interview`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `change_date` date NULL DEFAULT NULL,
  `change_user` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `active_status` int(11) NULL DEFAULT NULL,
  `preview_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ctf` date NULL DEFAULT NULL,
  `ctt` date NULL DEFAULT NULL,
  `atf` date NULL DEFAULT NULL,
  `att` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'interview list' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of interview
-- ----------------------------
INSERT INTO `interview` VALUES (25, 'aaaaa', 'aaaaaaaaaaaaaaaa', '2019-01-06', 'admin', 1, 'app/interview_image/pjSpLG9yqRsEnSzhFerRW7RYLh1FEmUkyK0QIKj9.jpeg', NULL, '2019-01-16', NULL, '2019-01-11');
INSERT INTO `interview` VALUES (26, 'wwwwwwwwwwwwwwwwwww', 'wwwwwwwwwwwwwwwwwwwwww', '2019-01-06', 'admin', 1, NULL, NULL, '2019-01-16', NULL, '2019-01-17');
INSERT INTO `interview` VALUES (27, 'ddddddddddddddddddd', 'dddddddddddddddddd', '2019-01-06', 'admin', 1, NULL, NULL, '2019-01-02', NULL, '2019-01-25');
INSERT INTO `interview` VALUES (28, 'sssssssssssss', 'sssssssssssssssssssssssssss', '2019-01-06', 'admin', 1, NULL, NULL, '2019-01-16', NULL, '2019-01-17');
INSERT INTO `interview` VALUES (29, 'xxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '2019-01-06', 'admin', 1, NULL, NULL, '2019-01-23', NULL, '2019-01-24');
INSERT INTO `interview` VALUES (30, 'Wordpress developer Interview', 'ssss', '2019-01-06', 'admin', 1, NULL, NULL, '2019-01-09', NULL, '2019-01-17');

-- ----------------------------
-- Table structure for interview_assessor
-- ----------------------------
DROP TABLE IF EXISTS `interview_assessor`;
CREATE TABLE `interview_assessor`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NULL DEFAULT NULL,
  `assessor_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `interview_assessor`(`interview_id`) USING BTREE,
  INDEX `interview_assessor_assessor`(`assessor_id`) USING BTREE,
  CONSTRAINT `interview_assessor` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `interview_assessor_assessor` FOREIGN KEY (`assessor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 75 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of interview_assessor
-- ----------------------------
INSERT INTO `interview_assessor` VALUES (64, 26, 41);
INSERT INTO `interview_assessor` VALUES (65, 26, 59);
INSERT INTO `interview_assessor` VALUES (69, 30, 41);
INSERT INTO `interview_assessor` VALUES (70, 30, 59);
INSERT INTO `interview_assessor` VALUES (71, 30, 60);
INSERT INTO `interview_assessor` VALUES (72, 27, NULL);
INSERT INTO `interview_assessor` VALUES (73, 30, 64);
INSERT INTO `interview_assessor` VALUES (74, 30, 77);

-- ----------------------------
-- Table structure for interview_candidate
-- ----------------------------
DROP TABLE IF EXISTS `interview_candidate`;
CREATE TABLE `interview_candidate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `interview_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `interview_candidate_interview`(`interview_id`) USING BTREE,
  INDEX `interview_candidate_candidate`(`candidate_id`) USING BTREE,
  CONSTRAINT `interview_candidate_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `interview_candidate_interview` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of interview_candidate
-- ----------------------------
INSERT INTO `interview_candidate` VALUES (33, 43, 30);
INSERT INTO `interview_candidate` VALUES (34, 44, 30);
INSERT INTO `interview_candidate` VALUES (35, 58, 30);
INSERT INTO `interview_candidate` VALUES (36, 62, 30);
INSERT INTO `interview_candidate` VALUES (37, 70, 30);
INSERT INTO `interview_candidate` VALUES (38, 73, 30);
INSERT INTO `interview_candidate` VALUES (39, 43, 27);
INSERT INTO `interview_candidate` VALUES (40, 44, 27);
INSERT INTO `interview_candidate` VALUES (41, 58, 27);
INSERT INTO `interview_candidate` VALUES (42, 62, 27);
INSERT INTO `interview_candidate` VALUES (43, 70, 27);
INSERT INTO `interview_candidate` VALUES (44, 73, 27);
INSERT INTO `interview_candidate` VALUES (45, 43, 26);
INSERT INTO `interview_candidate` VALUES (46, 44, 26);
INSERT INTO `interview_candidate` VALUES (47, 58, 26);
INSERT INTO `interview_candidate` VALUES (48, 62, 26);
INSERT INTO `interview_candidate` VALUES (49, 70, 26);
INSERT INTO `interview_candidate` VALUES (50, 73, 26);

-- ----------------------------
-- Table structure for interview_history
-- ----------------------------
DROP TABLE IF EXISTS `interview_history`;
CREATE TABLE `interview_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `interview_id` int(11) NOT NULL,
  `rundate` date NULL DEFAULT NULL,
  `availgrade` double NULL DEFAULT NULL,
  `grade` double NULL DEFAULT NULL,
  `interview_result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `interview_history_key_interview`(`interview_id`) USING BTREE,
  INDEX `interview_history_key_user`(`candidate_id`) USING BTREE,
  CONSTRAINT `interview_history_key_interview` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `interview_history_key_user` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of interview_history
-- ----------------------------
INSERT INTO `interview_history` VALUES (14, 43, 30, '2019-01-07', 16, 0, '[{\"id\":21,\"interview_id\":30,\"description\":\"ffggg\",\"qtype\":1,\"attach_media\":\"app\\/quiz_media\\/5c3259a3292dd.mp4\",\"grade\":7,\"qprepare\":0,\"qtime\":4,\"qdetail\":\"{\\\"ch\\\":[0,1],\\\"txt\\\":[\\\"f\\\",\\\"g\\\"]}\",\"order_val\":1,\"created_at\":null,\"updated_at\":\"2019-01-07 06:18:24\",\"runtime\":6,\"detail\":[\"0\",\"0\"],\"mark\":0},{\"id\":20,\"interview_id\":30,\"description\":\"please explain about wordpress basic concepts.\",\"qtype\":4,\"attach_media\":null,\"grade\":9,\"qprepare\":4,\"qtime\":5,\"qdetail\":null,\"order_val\":2,\"created_at\":null,\"updated_at\":\"2019-01-07 06:18:24\",\"runtime\":11,\"record\":\"app\\/record\\/5c32643fdd3f1.webm\"}]');

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NULL DEFAULT NULL,
  `sender_id` int(11) NULL DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_seen` int(11) NULL DEFAULT NULL,
  `deleted_from_sender` datetime(0) NULL DEFAULT NULL,
  `deleted_from_receiver` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for quiz
-- ----------------------------
DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtype` int(11) NOT NULL,
  `attach_media` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `grade` double UNSIGNED NOT NULL DEFAULT 1,
  `qprepare` int(11) NULL DEFAULT NULL,
  `qtime` int(11) NULL DEFAULT NULL,
  `qdetail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `order_val` int(11) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `interview_trigger`(`interview_id`) USING BTREE,
  CONSTRAINT `interview_trigger` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of quiz
-- ----------------------------
INSERT INTO `quiz` VALUES (12, 25, 'Your account has a past due balance. Please pay your past due balance of', 4, NULL, 1, 4, 4, NULL, 0, NULL, '2019-01-07 06:03:15');
INSERT INTO `quiz` VALUES (13, 25, 'sssssssssssssss', 1, NULL, 1, 0, 1342, '{\"ch\":[1,0],\"txt\":[\"\",\"\"]}', 0, NULL, '2019-01-07 06:06:22');
INSERT INTO `quiz` VALUES (14, 25, 'f', 2, NULL, 1, 0, 1342, '{\"ch\":[1,0],\"txt\":[\"d\",\"d\"]}', 3, NULL, '2019-01-07 05:44:31');
INSERT INTO `quiz` VALUES (20, 30, 'please explain about wordpress basic concepts.', 4, NULL, 9, 4, 5, NULL, 2, NULL, '2019-01-07 06:18:24');
INSERT INTO `quiz` VALUES (21, 30, 'ffggg', 1, 'app/quiz_media/5c3259a3292dd.mp4', 7, 0, 4, '{\"ch\":[0,1],\"txt\":[\"f\",\"g\"]}', 1, NULL, '2019-01-07 06:18:24');

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_history_id` int(11) NOT NULL,
  `assessor_id` int(11) NOT NULL,
  `review_time` datetime(0) NULL DEFAULT NULL,
  `quiz_id` int(11) NULL DEFAULT NULL,
  `grade` double NULL DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `on_interview_history`(`interview_history_id`) USING BTREE,
  CONSTRAINT `on_interview_history` FOREIGN KEY (`interview_history_id`) REFERENCES `interview_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `setting_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('admin_interview_page_search_date', '2018-12-31,2019-01-15');
INSERT INTO `settings` VALUES ('review_page_search_date_1', '2019-01-01,2019-01-16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` char(100) CHARACTER SET latin1 COLLATE latin1_bin NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `isadmin` int(11) NULL DEFAULT NULL,
  `phone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `employee_history` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `education_history` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `skill_grade` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email_unique`(`email`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Jaekson', 'admin@example.com', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', 'jl9rbTlMKIFW6YkSFN5yRX8bvfQgQT7SXle12E4EFbWO53oi0rVUPPbz2GCQ', '2019-01-03 18:02:24', '2018-12-22 07:16:58', 1, '9995556664', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (41, 'Assessor 1', 'asdf@asdf.asdf', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', '', '2018-12-28 12:03:01', '2018-12-28 01:37:28', 2, '9991562323', 'fssssssss', NULL, NULL, NULL, 'app/assessor/0YmBuyhOIlNJGtS5RtsTMYxIzvgcWIcAv26GJdXp.jpeg', NULL);
INSERT INTO `users` VALUES (43, 'Virat Kohli', 'Virat@gmail.com', '$2y$10$6y4LDPhzRQvwYl//uKyfzei.BFDVF02UuN0ZXFfG6WPBwsYTpGHqm', 'podz20DQXHnRCJf8IIhHLQQe7JqJWY3rP5HEY6ZQkU6xhuyGWb836v4fkokg', '2019-01-06 12:26:03', '2019-01-05 07:22:57', 0, '999556666', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat.bsdafsf af', '[]', '[]', '[]', 'app/candidate/5c27a09061f45.jpg', 'app/cv/5c295db69da7e.pdf');
INSERT INTO `users` VALUES (44, 'Kidambi Srikanth', 'Kidambi@gmail.com', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', '', '2018-12-29 18:07:05', '2018-12-29 18:07:05', 0, '9996665555', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat.b', '[]', '[]', '[]', NULL, NULL);
INSERT INTO `users` VALUES (58, 'f', 'f@f.f', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', NULL, '2018-12-31 02:03:48', '2018-12-31 02:03:48', 0, 'f', 'f', '[]', '[]', '[]', NULL, NULL);
INSERT INTO `users` VALUES (59, 'fffffffffffffffffff', 'ffff@ffff.ffffffff', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', 'DzElvxC2UBYlnInHnFanV6T22OYO1USehDRr0TBX872uxmi30axyp6flQgPn', '2019-01-05 10:12:11', '2018-12-31 02:51:07', 2, '3333333333', 'f', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (60, 'ddddddddddd', 'ddd@ddfd.dff', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', 'Qw292s9dNXsoR7hpN1fFLFEWS0oMGNPvf2Mm1JsjgWt6KsHVrW6HiHoyqMkc', '2019-01-05 10:13:30', '2018-12-31 02:51:34', 2, '3333333333', 'd', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (61, 'e', 'e@e.e', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', NULL, '2018-12-31 02:51:47', '2018-12-31 02:51:47', 2, 's', 'e', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (62, 'g', 'g@g.g', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', '', '2018-12-31 02:51:58', '2018-12-31 02:51:58', 0, 'f', 'g', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (64, 'g', 'g@g.gg', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', NULL, '2018-12-31 10:44:47', '2018-12-31 10:39:14', 2, 'fasdfasdfasdf', 'dsdf', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (66, 'f', 'ff@f.f', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', NULL, '2018-12-31 10:44:35', '2018-12-31 10:40:16', 2, 'f', 'f', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (70, 'sdfg', 'admin@example.comd', '$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C', NULL, '2018-12-31 20:54:12', '2018-12-31 20:54:12', 0, 'asdf', 'dfg', '[]', '[]', '[]', NULL, NULL);
INSERT INTO `users` VALUES (73, 'ggggggggggggggggggg', 'coolpluto1114@gmail.com', '$2y$10$vd.8l2EqkHmOSY8yiKqMue4Hk9Gd44PSpJIckgdU.o8h3Ntx4Ux/C', NULL, '2019-01-05 09:43:56', '2019-01-05 09:43:56', 0, '1231123123', 'f', '[]', '[]', '[]', NULL, NULL);
INSERT INTO `users` VALUES (77, 'f', 'f@fee.dfg', '$2y$10$b7dLeE6YxU3KcKv5a/PiPOM/1LaSo2uyH9Qvo04/l8CMbx7NF7Iq.', NULL, '2019-01-06 11:22:43', '2019-01-06 11:22:43', 2, '2342342342', 'f', NULL, NULL, NULL, 'app/assessor/CkJez4KGHfsRxKfyLDW9gEbrhk3BF7HafSup5FuR.png', NULL);

SET FOREIGN_KEY_CHECKS = 1;
